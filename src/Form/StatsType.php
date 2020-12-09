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
                    2020 => '2020'
                ]
            ])
            ->add('month', ChoiceType::class, [
                'choices' => [
                    '1' => "January",
                    '2' => "Februrary",
                    '3' => "March",
                    '4' => "April",
                    '5' => "May",
                    '6' => "June",
                    '7' => "July",
                    '8' => "August",
                    '9' => "September",
                    '10' => "October",
                    '11' => "November",
                    '12' => "December"
                ]
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
