<?php

namespace App\Service;

use App\Entity\City;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportCitiesService
{
    public function __construct(
        private CityRepository $cityRepository,
        private EntityManagerInterface $em,
    ) {
    }

    public function importCities(SymfonyStyle $io): void
    {
        $io->title('Importation des villes');

        $cities = $this->readCsvFile();

        // Barre de progression
        $io->progressStart(count($cities));

        foreach ($cities as $arrayCity) {
            // Avancement de la barre de progression
            $io->progressAdvance();
            $city = $this->createOrUpdateCity($arrayCity);

            $this->em->persist($city);
        }

        $this->em->flush();

        $io->progressFinish();
        $io->success('Importation terminée !');
    }

    private function readCsvFile(): Reader
    {
        $csv = Reader::createFromPath('%kernel.root_dir%/../import/cities.csv', 'r');
        $csv->setHeaderOffset(0);

        return $csv;
    }

    private function createOrUpdateCity(array $arrayCity): City
    {
        $city = $this->cityRepository->findOneBy(['inseeCode' => $arrayCity['insee_code']]);

        if (!$city) {
            $city = new City();
        }

        $city->setInseeCode($arrayCity['insee_code'])
            ->setCityCode($arrayCity['city_code'])
            ->setZipCode($arrayCity['zip_code'])
            ->setLabel($arrayCity['label'])
            ->setLatitude($arrayCity['latitude'])
            ->setLongitude($arrayCity['longitude'])
            ->setDepartmentName($arrayCity['department_name'])
            ->setDepartmentNumber($arrayCity['department_number'])
            ->setRegionName($arrayCity['region_name'])
            ->setRegionGeojson($arrayCity['region_geojson_name']);

        return $city;
    }
}
