<?php

namespace App\Form;

use App\Entity\Computer;
use App\Entity\Contact;
use App\Entity\MemberShip;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberShipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'adhgem3' => 'Adhésion GEM 3 mois',
                    'adhrsa' => 'Adhésion RSA',
                    'adhsmic' => 'Adhésion SMIC',
                    'adhbene' => 'Adhésion bénévole',
                    'adhinsta' => 'Adhésion installation Linux',
                    'adhsupsmic' => 'Adhésion sup SMIC',
                    'gift' => 'Don',
                    'sale' => 'Vente',
                ],
                'label' => 'Type'
            ])
            ->add('amount', MoneyType::class, [
                'currency' => 'EUR',
                'divisor' => 100,
              
            ] )
            ->add('member', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => 'lastname'
            ])
            ->add('computer', EntityType::class, [
                'class' => Computer::class,
                'choice_label' => 'serial',
                'placeholder' => 'Sélectionner un ordinateur',
                'required' => false
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Commentaire',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Entrer un commentaire'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MemberShip::class,
        ]);
    }
}
