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
            ->add('years', ChoiceType::class, [
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
            ->add('months', ChoiceType::class, [
                'choices' => [
                    'janvier' => 'Janvier',
                    'fevrier' => 'Fevrier',
                    'mars' => 'Mars',
                    'avril' => 'Avril',
                    'mai' => 'Mai',
                    'juin' => 'Juin',
                    'juillet' => 'Juillet',
                    'aout' => 'Aout',
                    'septembre' => 'Septembre',
                    'octobre' => 'Octobre',
                    'novembre' => 'Novembre',
                    'decembre' => 'Decembre',
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
