<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Forecast;
use App\Repository\CityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForecastType extends AbstractType
{
    private CityRepository $cities;
    public function __construct(CityRepository $cityRepository)
    {
        $this->cities = $cityRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $cityNames = $this->cities->findAll();




        $builder
            ->add('ProbabilityOfPrecipitation')
            ->add('Cloudy')
            ->add('Wind')
            ->add('Temperature')
            ->add('Humidity')
            ->add('AmountOfPrecipitation')
            ->add('Date')
            ->add('city', ChoiceType::class, [
                'choices'=>array($cityNames),
                'choice_label' => function($cityNames, $key, $index) {
                    return strtoupper($cityNames->getName() .", " .$cityNames->getCountryCode());
                },
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forecast::class,
        ]);
    }
}
