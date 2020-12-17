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
                    'adhgem3' => MemberShip::MEMBERSHIP_GEM,
                    'adhrsa' => MemberShip::MEMBERSHIP_RSA,
                    'adhsmic' => MemberShip::MEMBERSHIP_SMIC,
                    'adhbene' => MemberShip::MEMBERSHIP_BENEVOLE,
                    'adhinsta' => MemberShip::MEMBERSHIP_LINUX,
                    'adhsupsmic' => MemberShip::MEMBERSHIP_SUP,
                    'gift' => MemberShip::GIFT,
                    'sale' => MemberShip::SALES,
                ],
                'label' => 'Type d\'adhésion'
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
                'placeholder' => "Pas D'ordinateur",
                'required' => false
            ])
            ->add('residual', MoneyType::class, [
                'currency' => 'EUR',
                'divisor' => 100,
                'required' => false
            ])
            ->add('mode', ChoiceType::class, [
                'choices' => MemberShip::PAY
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