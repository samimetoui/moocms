<?php

namespace sf_moocms\MoocmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CategoryType extends AbstractType {

  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
    ->add('name')
    ->add('description', TextareaType::class)
  ;
  }

  // public function configureOptions(OptionsResolverInterface $resolver) {
  //   $resolver->setDefaults(array(
  //     'data_class' => 'sf_moocms\MoocmsBundle\Entity\Topic'
  //   ));
  // }

     /**
    * @return string
    */

    public function getBlockPrefix() {
     return 'moocmsbundle_category';
   }

}
