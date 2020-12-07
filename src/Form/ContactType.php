<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', TextType::class, [
                'label' => "Motif",
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisissez le motif...'
                ]
            ])
            ->add('title', ChoiceType::class, [
                'choices' => Contact::TITLES,
                'label' => "Genre", 
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'attr' => [ 'placeholder' => 'Saisissez le Nom'],
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
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'attr' => [ 'placeholder' => 'Saisissez le Prénom'],
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
            ])
            ->add('mail', EmailType::class, [
                "label" => 'Email',
                'required' => false,
                'attr' => ['placeholder' => "Saisissez l'adresse email"]
            ])
            ->add('phone', TextType::class, [
                'label' => "Téléphone",
                'required' => false,
                'attr' => [ 'placeholder' => 'Saisissez le Numero de téléphone']
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Commentaire",
                'required' => false,
                'attr' => [ 
                    'placeholder' => 'Saisissez un commentaire',
                    'rows' => 10,
                    'cols' => 40
                    ]
            ])
            ->add('adress', AdressType::class,[
                'label' => false,
                'required' => false
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
