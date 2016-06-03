<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Fixtures\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalificacionUsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('calificacion','choice', array('choices' => array
            ('1'   => 'Positivo','2' => 'Negativo',),'multiple' => false,))
            ->add('paraUsuario','entity',
                array('label' => 'CaificacionUsuario: ',
                    'class' => 'AppBundle:Usuario',
                    'property' => 'username'))
            ->add('Calificar',SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CalificacionUsuario'
        ));
    }
}
