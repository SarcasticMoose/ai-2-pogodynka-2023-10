<?php

namespace App\Form;

use App\Entity\City;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name',null,[
                'attr' => [
                    'placeholder' => 'Enter city name'
                ],
            ])
            ->add('Country',ChoiceType::class,[
                'choices' => [
                    'Poland' => 'PL',
                    'England' => 'EN',
                    'United States Of America' => "USA",
                    'Germany' => "DE",
                    'Czech Republic' => "CZ",
                    'Ukraine' => 'UA',
                    'Slovakia' => 'SL'
                ]
            ])
            ->add('Longitude',TextType::class)
            ->add('Latitude',TextType::class)
            ->add('Region')
            ->add('CountryCode')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
        ]);
    }
}
