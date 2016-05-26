<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class)
            ->add('password', RepeatedType::class, [
                    'type'=>PasswordType::class,
                    'first_options'=>['label'=>'Password'],
                    'second_options'=>['label'=>'Repeat password']
                ])
            ->add('pregunta', TextType::class)
            ->add('respuesta', TextType::class)
            ->add('rol', HiddenType::class)
            ->add('fechaDeNacimiento', DateType::class)
            ->add('edad', NumberType::class)
            ->add('pais', CountryType::class)
            ->add('provincia', TextType::class)
            ->add('localidad', TextType::class)
            ->add('calle', TextType::class)
            ->add('isActive', HiddenType::class)
            ->add('Registrarme', SubmitType::class)
        ;
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
}
