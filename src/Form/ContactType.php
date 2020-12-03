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

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', TextType::class, [
                'label' => "Motif"
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => Contact::TITLES,
                'label' => "Sexe"
            ])
            ->add('lastname', TextType::class, [
                'label' => "Nom",
                'attr' => [ 'placeholder' => 'Saisissez le Nom']
            ])
            ->add('firstname', TextType::class, [
                'label' => "Prénom",
                'attr' => [ 'placeholder' => 'Saisissez le Prénom']
            ])
            ->add('mail', EmailType::class, [
                "label" => 'Email',
                'attr' => ['placeholder' => "Saisissez l'adresse email"]
            ])
            ->add('phone', TextType::class, [
                'label' => "Téléphone",
                'attr' => [ 'placeholder' => 'Saisissez le Numero de téléphone']
            ])
            ->add('comment', TextareaType::class, [
                'label' => "Commentaire",
                'attr' => [ 
                    'placeholder' => 'Saisissez un commentaire',
                    'rows' => 20,
                    'cols' => 50
                    ]
            ])
            ->add('adress', AdressType::class,[
                'label' => false
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
