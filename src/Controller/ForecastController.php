<?php

namespace App\Controller;

use App\Entity\City;
use App\Repository\CityRepository;
use App\Repository\ForecastRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForecastController extends AbstractController
{

    #[Route('/forecast/{id}', name: 'app_forecast', requirements: ['id' => '\d+'])]
    public function index(): Response
    {
        return $this->render('forecast/city.html.twig', [
            'controller_name' => 'ForecastController',
        ]);
    }

    #[Route('/wheather/{cityName}/{countryCode}',defaults: ['countryCode' => 'PL'])]
    public function GetForecast(
        ForecastRepository $forecastRepository,
        #[MapEntity(expr: 'repository.findByName(cityName,countryCode)')]
        City $city) : Response
    {
        $forecast = $forecastRepository->findByLocalization($city);

        return $this->render("forecast/city.html.twig",[
            'city' => $city,
            'forecast' => $forecast
        ]);
    }
}
