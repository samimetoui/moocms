<?php
namespace sf_moocms\MoocmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

use sf_moocms\MoocmsBundle\Entity\Activity;
use sf_moocms\MoocmsBundle\Repository\ActivityRepository;
use sf_moocms\UserBundle\Entity\User;


class SequenceType extends AbstractType {

  public function __construct(){
  }

 /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
 public function buildForm(FormBuilderInterface $builder, array $options) {

  $user = $options['user'];

  $builder
  ->add('number')
  ->add('title')
  ->add('summary', TextareaType::class)
  ->add('goals',  TextareaType::class, array(
    'required' => false,
  ))
  ->add('pedagogical_method', ChoiceType::class, array(
    'required' => false,
    'choices' => array(
      'Expositive' => 'expositive',
      'Démonstrative' => 'demonstrative',
      'Experientielle' => 'experiential',
      'Interrogative' => 'interrogative',
      'Active' => 'active',
    ),
  'choices_as_values' => true,
))
  ->add('method_description', TextareaType::class, array(
    'required' => false,
  ))

  ->add('content', CKEditorType::class, array(
    'config_name' => 'new_config',
  ))
  
  ->add('activity',EntityType::class, array(
    'class' => 'MoocmsBundle:Activity',
    'choice_label' => 'title',
    'query_builder' => function(ActivityRepository $repo) use ($user) {
      return $repo->getCurrentUserActivities($user);
    },
    'required' => false
  ))
  ;
}

 /**
  * @param OptionsResolverInterface $resolver
  */
 public function configureOptions(OptionsResolver $resolver) {
  $resolver->setDefaults(array(
    'data_class' => 'sf_moocms\MoocmsBundle\Entity\Sequence',
    'user' => null,
  ));
}



 /**
  * @return string
  */
 public function getBlockPrefix() {
  return 'moocmsbundle_sequence';
}

}
