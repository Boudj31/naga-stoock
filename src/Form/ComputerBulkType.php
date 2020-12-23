<?php
 
 namespace App\Form;
 
 use Symfony\Component\Form\AbstractType;
 use Symfony\Component\Form\CallbackTransformer;
 use Symfony\Component\Form\Extension\Core\Type\TextareaType;
 use Symfony\Component\Form\FormBuilderInterface;
 use Symfony\Component\OptionsResolver\OptionsResolver;
 
 class ComputerBulkType extends AbstractType
 {
     /**
      * @param FormBuilderInterface $builder
      * @param array                $options
      */
     public function buildForm(FormBuilderInterface $builder, array $options)
     {
         $builder
             ->add('pattern', ComputerType::class, [
                 'label' => false,
             ])
             ->add('serials', TextareaType::class, [
                 'label' => 'Numéros de série'
             ])
         ;
 
         $builder->get('serials')->addModelTransformer(new CallbackTransformer(
             function (array $serialsAsArray): string {
                 return implode("\n", $serialsAsArray);
             },
             function (string $serialsAsString): array {
                 return explode("\n", $serialsAsString);
             }
         ));
     }
 
     /**
      * @param OptionsResolver $resolver
      */
     public function configureOptions(OptionsResolver $resolver)
     {
         $resolver->setDefaults([
             'label_format' => 'computer.%name%.label',
         ]);
     }
 }