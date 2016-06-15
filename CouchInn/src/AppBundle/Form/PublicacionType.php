<?php

namespace AppBundle\Form;

use AppBundle\Entity\Publicacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicacionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('foto', FileType::class, [
                'data_class'=>null
            ])
            ->add('path', HiddenType::class)
            ->add('fechaDisponibleInicio',DateType::class,[
                'years'=>range(date('Y'), date('Y')+3),
                'data'=>new \DateTime('now'),
            ])
            ->add('fechaDisponibleFin',DateType::class,[
                'years'=>range(date('Y'), date('Y')+3),
                'data'=>new \DateTime('tomorrow'),
            ])
            ->add('tipo','entity',
                array('label' => 'TipoHospedaje: ',
                    'class' => 'AppBundle:TipoHospedaje',
                    'property' => 'tipo'))
            ->add('maxPersonas',NumberType::class)
            ->add('costo',IntegerType::class)
            ->add('pais',CountryType::class)
            ->add('provincia',TextType::class)
            ->add('localidad',TextType::class)
            ->add('calle',TextType::class)
            ->add('descripcion',TextareaType::class)
            ->add('agregarPublicacion',SubmitType::class);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Publicacion'
        ));
    }
}
