<?php

namespace Basso\VisualCalBundle\Form;

use Petkopara\MultiSearchBundle\Form\Type\MultiSearchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AlmacenFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('search', MultiSearchType::class, array(
                    'class' => 'BassoVisualCalBundle:Almacen',
                    'search_fields' => array( //optional, if it's empty it will search in the all entity columns
                        'id',
                        'descripcion',
                 ), 
                    ));
                    
       $builder->setMethod('GET');

    }

    public function getBlockPrefix()
    {
        return null;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
