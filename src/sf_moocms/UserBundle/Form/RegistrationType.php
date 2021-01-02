<?php
namespace sf_moocms\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
// use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
    	$builder
        ->add('firstname', null, array('label' => 'Prénom'))
    	  ->add('lastname', null, array('label' => 'Nom'));
        
    }

    public function getParent(){
    	return 'FOS\UserBundle\Form\Type\RegistrationFormType'; //'fos_user_registration';
    }

    public function getBlockPrefix(){
    	return 'app_user_registration';
    }

    public function getName(){
    	return $this->getBlockPrefix();
    }
  }