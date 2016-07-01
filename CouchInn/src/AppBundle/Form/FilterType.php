<?php

namespace AppBundle\Form;

use AppBundle\Entity\Filter;
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

class FilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPersonas',NumberType::class,array('required' => false))
            ->add('monto',NumberType::class,array('required' => false))
            ->add('fechaDisponibleInicio',DateType::class,[
                'years'=>range(date('Y'), date('Y')+3),
                'data'=>new \DateTime('now'),
            ],array('required' => false))
            ->add('fechaDisponibleFin',DateType::class,[
                'years'=>range(date('Y'), date('Y')+3),
                'data'=>new \DateTime('tomorrow'),
            ],array('required' => false))
            ->add('filtrar',SubmitType::class);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Filter'
        ));
    }
}
