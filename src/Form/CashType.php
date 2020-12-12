<?php

namespace App\Form;

use App\Entity\Cash;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
            ->add('amountIn', MoneyType::class, [
                'currency' => 'EUR',
                'divisor' => 100, 
                'disabled' => true 
            ])
            ->add('amountOut', MoneyType::class, [
                'currency' => 'EUR',
                'divisor' => 100, 
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
