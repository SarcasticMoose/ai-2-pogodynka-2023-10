<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class WeatherAPiController extends AbstractController
{
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        WeatherUtil $util,
        #[MapQueryParameter] string $format = 'json',
        #[MapQueryParameter('twig')] bool $twig = false,
    ): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country,$city);

        $data = [
            'measurements' => array_map(fn(Measurement $m) => [
                'city' => $m->getLocation()->getCity(),
                'country' => $m->getLocation()->getCountry(),
                'date' => $m->getDate()->format('Y-m-d'),
                'celsius' => $m -> getCelsius(),
                'fahrenheit' => $m -> getFahrenheit()
        ],$measurements),];

        if($format != 'json'){
            if(!$twig){
                $csvData = null;
                foreach($data as $entries){
                    foreach ($entries as $fields) {
                        $csvData .= implode(',', [$fields['city'], $fields['country'], $fields['date'],$fields['celsius'],$fields['fahrenheit']]).PHP_EOL;
                        return new Response($csvData,200);
                    }
                }
            }
            return $this->render('weather_api/index.csv.twig', [
                'city' => $city,
                'country' => $country,
                'measurements' => $measurements,
            ]);

        }
        if(!$twig){
            return $this->json([$data]);
        }

        return $this->render('weather_api/index.jsonformat.twig', [
            'city' => $city,
            'country' => $country,
            'measurements' => $measurements,
        ]);
    }
}
