<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalificacionPublicacionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
<<<<<<< HEAD
        $builderz
=======
        $builder
            ->add('calificacion','choice', array('choices' => array
            ('1'   => 'Positivo','2' => 'Negativo',),'multiple' => false,))
            ->add('publicacion',TextType::class)
            ->add('Calificar',SubmitType::class)
>>>>>>> 660838add9bebbbc12fe2333862e47206a306217
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CalificacionPublicacion'
        ));
    }
}
