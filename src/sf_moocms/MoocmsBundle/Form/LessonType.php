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

use sf_moocms\MoocmsBundle\Form\ImageType;
use sf_moocms\MoocmsBundle\Entity\Activity;
use sf_moocms\MoocmsBundle\Repository\ActivityRepository;
use sf_moocms\MoocmsBundle\Entity\Category;
use sf_moocms\UserBundle\Entity\User;


class LessonType extends AbstractType {

  public function __construct(){
  }

  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options) {

    $user = $options['user'];

    $builder
    ->add('name')
    ->add('summary', TextareaType::class, array(
    ))
    
    ->add('prerequisite', TextareaType::class, array(
      'required' => false,
    ))

    ->add('goals', TextareaType::class, array(
      'required' => false,
    ))

    ->add('behaviours', TextareaType::class, array(
      'required' => false,
    ))

    ->add('purposes', TextareaType::class, array(
      'required' => false,
    ))

    ->add('promote')
    ->add('published')

    ->add('level',ChoiceType::class, array(
      'choices' => array(
        'Néant' => 0,
        'Initiation' => 1,
        'Moyen' => 2,
        'Avancé' => 3,
        'Expert' => 4
      ),
      'choices_as_values' => true,
    ))

    ->add('topic', EntityType::class, array(
      'class' => 'MoocmsBundle:Topic',
      'choice_label' => 'name',
    ))

    ->add('categories', EntityType::class, array(
      'class' => 'MoocmsBundle:Category',
      'choice_label' => 'name',
      'multiple'     => true,
      'required' => false
      // 'expanded' => true,
    ))

    ->add('activity', EntityType::class, array(
      'class' => 'MoocmsBundle:Activity',
      'choice_label' => 'title',
      'query_builder' => function(ActivityRepository $repo) use ($user) {
        return $repo->getCurrentUserActivities($user);
        },
        'required' => false
      ))

      ->add('image', ImageType::class)
      ;
    }

    /**
    * @param OptionsResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver) {
      $resolver->setDefaults(array(
        'data_class' => 'sf_moocms\MoocmsBundle\Entity\Lesson',
        'user' => null,
      ));
    }

    /**
    * @return string
    */
    public function getBlockPrefix() {
      return 'moocmsbundle_lesson';
    }

  }
