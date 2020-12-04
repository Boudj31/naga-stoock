<?php

namespace App\Form;

use App\Entity\Society;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SocietyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
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
            ->add('representativeName', TextType::class, [
                'label' => 'Raison Sociale',
                'required' => false,
                'attr' => [
                    'placeholder' => "Entrez la raison sociale"
                ]
            ])
            ->add('representativeMail', TextType::class, [
                'label' => 'Adresse email',
                'required' => false,
                'attr' => [
                    'placeholder' => "Entrez une adresse email"
                ]
            ])
            ->add('representativePhone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
                'attr' => [
                    'placeholder' => "Numéro de téléphone"
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Mettre un commentaire'
                ]
            ])
            ->add('adress', AdressType::class, [
                'label' => false,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Society::class,
        ]);
    }
}
