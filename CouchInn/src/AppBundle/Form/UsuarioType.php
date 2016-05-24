<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            ->add('nombreDeUsuario', TextType::class, ['label'=>'Nombre de Usuario:'])
            ->add('password', PasswordType::class, ['label'=>'Contraseña:'])
            ->add('pregunta', TextType::class, ['label'=>'Pregunta para recuperacion de contraseña:'])
            ->add('respuesta', TextType::class, ['label'=>'Respuesta para recuperación de contraseña:'])
            ->add('rol', HiddenType::class)
            ->add('fechaDeNacimiento', DateType::class, ['label'=>'Fecha de Nacimiento:'])
            ->add('edad', IntegerType::class, ['label'=>'Su edad:'])
            ->add('pais', CountryType::class, ['label'=>'Pais donde vive:'])
            ->add('provincia', LocaleType::class, ['label'=>'Provincia donde vive:'])
            ->add('localidad', TextType::class, ['label'=>'Localidad donde vive:'])
            ->add('calle', TextType::class, ['label'=>'Domicilio donde vive:'])
            ->add('registrar', SubmitType::class, ['label'=>'Registrar'])
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
