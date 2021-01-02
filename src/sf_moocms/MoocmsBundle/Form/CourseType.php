<?php

namespace sf_moocms\MoocmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;




class CourseType extends AbstractType {

 /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
 public function buildForm(FormBuilderInterface $builder, array $options) {
  $builder
  ->add('title')
  ->add('summary', TextareaType::class, array(
  ))
  ->add('prerequiste', TextareaType::class, array(
    'required' => false,
  ))
  ->add('goals', TextareaType::class, array(
    'required' => false,
  ))
  ->add('topic', EntityType::class, array(
    'class' => 'MoocmsBundle:Topic',
    'choice_label' => 'name',
  ))
  ->add('image',ImageType::class)
  ;
}

 /**
  * @param OptionsResolverInterface $resolver
  */
 public function configureOptions(OptionsResolver $resolver) {
  $resolver->setDefaults(array(
    'data_class' => 'sf_moocms\MoocmsBundle\Entity\Course'
  ));
}

 /**
  * @return string
  */
 public function getBlockPrefix() {
  return 'moocmsbundle_course';
}

}
