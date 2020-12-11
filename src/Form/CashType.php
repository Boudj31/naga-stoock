<?php

namespace App\Form;

use App\Entity\Cash;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CashType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'deposit' => 'Déposer'
            ]])
            ->add('amountIn', NumberType::class, [
                'disabled' => true
            ])
            ->add('amountOut')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cash::class,
        ]);
    }
}
