<?php

namespace App\Form;

use App\Entity\Computer;
use App\Entity\Society;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComputerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receivedAt', TypeDateType::class, [
                'input' => 'datetime',
                'html5' => true,
                'widget' => 'single_text',
                'label' => 'Date de réception'
            ])
            ->add('serial', TextType::class, [
                'label' => 'Numéro de série',
                'attr' => [
                    'placeholder' => 'Exemple 65HFO...'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => Computer::TYPE_STATUS
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaires',
                'attr' => [
                   'placeholder' => "Entrer un commentaire..."
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => Computer::TYPE_VALUES,
                'label' => 'Types',
                'attr' => [
                    'placeholder' => 'Ajouter un commentaire'
                ]
            ])
            ->add('donor', EntityType::class, [
                'class' => Society::class,
                'choice_label' => 'name',
                'label' => 'Donateur'
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Computer::class,
        ]);
    }
}
