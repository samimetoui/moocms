<?php
namespace sf_moocms\MoocmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use FOS\CKEditorBundle\Form\Type\CKEditorType;


class ActivityType extends AbstractType{

  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options) {

    $builder
    ->add('title')
    ->add('goals', TextareaType::class, array(
      'required' => false,
    ))
    ->add('summary', TextareaType::class, array(
    /*'required' => false,*/
    ))
    ->add('category', ChoiceType::class, array(
      'required' => false,
      'choices' => array(
        'Projet' => 'project',
        'Situation problème' => 'problem',
        'Activité de groupe' => 'group_work',
        'Autre' => 'other',
      ),
      'choices_as_values' => true,
    ))
    ->add('content', CKEditorType::class, array(
      'config_name' => 'new_config',
    ))
    ->add('document',DocumentType::class, array(
      'required' => false,
    ))
    ;
  }

  /**
  * @param OptionsResolverInterface $resolver
  */
  public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
      'data_class' => 'sf_moocms\MoocmsBundle\Entity\Activity'
    ));
  }

  /**
  * @return string
  */
  public function getBlockPrefix() {
    return 'moocmsbundle_activity';
  }

}
