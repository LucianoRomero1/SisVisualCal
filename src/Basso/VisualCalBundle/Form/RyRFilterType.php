<?php

namespace Basso\VisualCalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class RyRFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
            ->add('ryRTipo', Filters\EntityFilterType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\RyRTipo',
                'choice_label' => 'descripcion',
                'label' => 'Tipo'
            )) 
            ->add('fecha', Filters\DateRangeFilterType::class,  array(
                'label' => 'Fecha',
                'left_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'desde'
                ),
                'right_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'hasta'
                )
            ))
            ->add('gage', Filters\EntityFilterType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Gage',
                'choice_label' => 'id',
                'label' => 'Instrumento',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\GageRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.id', 'ASC');
                    },
            )) 
        ;
        $builder->setMethod("GET");


    }

    public function getBlockPrefix()
    {
        return null;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
            'csrf_protection' => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
