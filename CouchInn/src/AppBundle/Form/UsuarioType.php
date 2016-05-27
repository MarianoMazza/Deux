<?php

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ->remove('email')
            ->add('pregunta', TextType::class, ['label'=>'Pregunta secreta: '])
            ->add('respuesta', TextType::class, ['label'=>'Respuesta: '])
            ->add('fechaDeNacimiento', DateType::class)
            ->add('pais', CountryType::class)
            ->add('provincia', TextType::class)
            ->add('localidad', TextType::class)
            ->add('calle', TextType::class)
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
