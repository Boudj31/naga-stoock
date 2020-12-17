<?php

namespace App\Form;

use App\Entity\Cash;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CashType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le prénom doit faire au moins 3 caractères.',
                        'max' => 4096,
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
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
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Dépot' => 'Dépot'
            ]])
            ->add('amountIn', MoneyType::class, [
                'currency' => 'EUR',
                'divisor' => 100, 
                'disabled' => true,
                'label' => 'Montant entré',
                'attr' => [ 'placeholder' => 'Vous ne pouvez pas entrer dans ce champs']
            ])
            ->add('amountOut', MoneyType::class, [
                'currency' => 'EUR',
                'divisor' => 100,
                'label' => 'Montant sortie',
                'attr' => ['placeholder' => 'Entrez la somme à déduire de la caisse'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champs ne peut pas être vide.',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cash::class,
        ]);
    }
}
