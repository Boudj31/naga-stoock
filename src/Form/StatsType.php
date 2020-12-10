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
                    2013 => '2013',
                    2014 => '2014',
                    2015 => '2015',
                    2016 => '2016',
                    2017 => '2017',
                    2018 => '2018',
                    2019 => '2019',
                    2020 => '2020',
                    2021 => '2021'
                ],
                'label' => 'Année'
            ])
            ->add('month', ChoiceType::class, [
                'choices' => [
                    1 => "Janvier",
                    2 => "Fevrier",
                    3 => "Mars",
                    4 => "Avril",
                    5 => "Mai",
                    6 => "Juin",
                    7 => "Juillet",
                    8 => "Aout",
                    9 => "Septembre",
                    10 => "Octobre",
                    11 => "Novembre",
                    12 => "Décembre"
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
