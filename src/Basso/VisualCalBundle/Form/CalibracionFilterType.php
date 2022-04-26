<?php

namespace Basso\VisualCalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

class CalibracionFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\NumberFilterType::class)
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
            ->add('realizadaPor', Filters\TextFilterType::class, array (
                'condition_pattern' => FilterOperands::STRING_CONTAINS))
            ->add('pasa', Filters\CheckboxFilterType::class)
        
            ->add('gage', Filters\EntityFilterType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Gage',
                'choice_label' => 'id',
                'label' => 'Instrumento',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\GageRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.id', 'ASC');
                    },
            )) 
            ->add('almacen', Filters\EntityFilterType::class, array(
                    'class' => 'Basso\VisualCalBundle\Entity\Almacen',
                    'choice_label' => 'descripcion',
                    'query_builder' => function (\Basso\VisualCalBundle\Repository\AlmacenRepository $er) {
                        return $er->createQueryBuilder('d')
                        ->orderBy('d.descripcion', 'ASC');
                        },
            )) 
            ->add('calibracionTipo', Filters\EntityFilterType::class, array(
                    'class' => 'Basso\VisualCalBundle\Entity\CalibracionTipo',
                    'choice_label' => 'descripcion',
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
