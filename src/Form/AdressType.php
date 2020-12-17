<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adressLine1', TextType::class, [
                'label' => "Adresse",
                'required' => false,
                'attr' => [ 'placeholder' => "Saisissez l'adresse"],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom doit faire au moins 3 caractères.',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('adressLine2', TextType::class, [
                'label' => "Complément d'adresse",
                'required' => false,
                'attr' => [ 'placeholder' => "Saisissez le complément d'adresse"]
            ])
            ->add('zipcode', TextType::class, [
                'label' => "Code Postal",
                'required' => false,
                'attr' => [ 'placeholder' => 'Saisissez le code postal']
            ])
            ->add('city', TextType::class, [
                'label' => "Ville",
                'required' => false,
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
