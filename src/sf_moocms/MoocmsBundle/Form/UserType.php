<?php
namespace sf_moocms\MoocmsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType{

  /**
  * @param FormBuilderInterface $builder
  * @param array $options
  */
  public function buildForm(FormBuilderInterface $builder, array $options) {
    $builder
    ->add('firstname')
    ->add('lastname')
    ->add('username')
    ->add('email')

    ->add('roles', ChoiceType::class, array(
      'attr'  =>  array('class' => 'form-control',
      'style' => 'margin:5px 0;'),
      'choices' =>
      array(
        'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
        'ROLE_ADMIN' => 'ROLE_ADMIN',
        'ROLE_USER' => 'ROLE_USER'
      ) ,
      'multiple' => true,
      'required' => true,
    )
  );

  $builder->remove('plainPassword');

}


public function getParent() {
  return 'FOS\UserBundle\Form\Type\RegistrationFormType';
  // Or for Symfony < 2.8
  // return 'fos_user_registration';
}

public function getBlockPrefix() {
  return 'app_user_registration';
}

// For Symfony 2.x
public function getName() {
  return $this->getBlockPrefix();
}


}
