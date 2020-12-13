<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year', ChoiceType::class, [
                'choices' => [
                    2013 => 2013,
                    2014 => 2014,
                    2015 => 2015,
                    2016 => 2016,
                    2017 => 2017,
                    2018 => 2018,
                    2019 => 2019,
                    2020 => 2020,
                    2021 => 2021
                ],
                'label' => 'Année'
            ])
            ->add('month', ChoiceType::class, [
                'choices' => [
                    'Janvier' => 1,
                    'Fevrier' => 2,
                    'Mars' => 3,
                    'Avril' => 4,
                    'Mai' => 5,
                    'Juin' => 6,
                    'Juillet' => 7,
                    'Aout' => 8,
                    'Septembre' => 9,
                    'Octobre' => 10,
                    'Novembre' => 11,
                    'Décembre' => 12
                ],
                'label' => 'Mois'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
