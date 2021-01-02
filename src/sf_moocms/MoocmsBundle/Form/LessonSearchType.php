<?php

namespace sf_moocms\MoocmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use sf_moocms\MoocmsBundle\Entity\Category;
use sf_moocms\MoocmsBundle\Entity\Topic;

class LessonSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('categories',EntityType::class, [
        'required' => false,
        'label' => false,
        'class' => Category::class,
        'choice_label' => 'name',
        'multiple' => true
      ])
      ->add('topic',EntityType::class, [
        'required' => false,
        'placeholder' => 'Tous...',
        'label' => false,
        'class' => Topic::class,
        'choice_label' => 'name',
        'multiple' => false
      ])
      ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'sf_moocms\MoocmsBundle\Entity\LessonSearch',
        'method' => 'get',
        'csrf_protection' => false
      ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
      return 'moocmsbundle_lessonsearch';
    }


  }
