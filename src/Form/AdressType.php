<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adressLine1', TextType::class, [
                'label' => "Adresse",
                'attr' => [ 'placeholder' => "Saisissez l'adresse"]
            ])
            ->add('adressLine2', TextType::class, [
                'label' => "Complément d'adresse",
                'attr' => [ 'placeholder' => "Saisissez le complément d'adresse"]
            ])
            ->add('zipcode', TextType::class, [
                'label' => "Code Postal",
                'attr' => [ 'placeholder' => 'Saisissez le code postal']
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'attr' => [ 'placeholder' => 'Saisissez la ville']
            ])
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
