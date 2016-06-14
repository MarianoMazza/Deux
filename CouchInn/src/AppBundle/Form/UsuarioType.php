<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class UsuarioType extends BaseType
{
    private $class;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'Nombre de usuario:'))
            ->add('plainPassword', RepeatedType::class, array(
                'type'=>'password',
                'first_options' => array('label' => 'Contraseña: '),
                'second_options' => array('label' => 'Repetir contraseña: '),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('email', null, array('label' => 'Email:'))
            ->add('fechaDeNacimiento', DateType::class, [
                'years'=>range(1940, 2016),
                'label'=>'Fecha de nacimiento: ',
            ])
            ->add('pais', CountryType::class, ['label'=>'Pais: '])
            ->add('provincia', TextType::class, ['label'=>'Provincia: '])
            ->add('localidad', TextType::class, ['label'=>'Localidad: '])
            ->add('calle', TextType::class, ['label'=>'Domicilio: '])
            ->add('submit', SubmitType::class, ['label'=>'Registrarme '])
        ;
    }

    public function __construct($class)
    {
        parent::__construct($class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
