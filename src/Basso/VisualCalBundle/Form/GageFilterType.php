<?php

namespace Basso\VisualCalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

class GageFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', Filters\TextFilterType::class, array (
            'condition_pattern' => FilterOperands::STRING_CONTAINS))
            ->add('nroSerie', Filters\TextFilterType::class, array (
            'condition_pattern' => FilterOperands::STRING_CONTAINS))
            ->add('descripcion', Filters\TextFilterType::class, array (
            'condition_pattern' => FilterOperands::STRING_CONTAINS))
            ->add('calProximaFecha', Filters\DateRangeFilterType::class,  array(
                'label' => 'Próx. Calibración',
                'left_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'desde'
                ),
                'right_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'hasta'
                )
            ))
            ->add('rrProximaFecha', Filters\DateRangeFilterType::class,  array(
                'label' => 'Próx. RyR',
                'left_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'desde'
                ),
                'right_date_options' => array(
                    'widget' => 'single_text',
                    'label' => 'hasta'
                )
            ))
            ->add('estado', Filters\EntityFilterType::class, array(
                    'class' => 'Basso\VisualCalBundle\Entity\Estado',
                    'choice_label' => 'descripcion',
                    'query_builder' => function (\Basso\VisualCalBundle\Repository\EstadoRepository $er) {
                        return $er->createQueryBuilder('d')
                        ->orderBy('d.descripcion', 'ASC');
                        },
            )) 
            ->add('tipo', Filters\EntityFilterType::class, array(
                    'class' => 'Basso\VisualCalBundle\Entity\Tipo',
                    'choice_label' => 'descripcion',
                    'label' => 'Color',
                    'query_builder' => function (\Basso\VisualCalBundle\Repository\TipoRepository $er) {
                        return $er->createQueryBuilder('d')
                        ->orderBy('d.descripcion', 'ASC');
                        },
            )) 
            ->add('ubicacion', Filters\EntityFilterType::class, array(
                    'class' => 'Basso\VisualCalBundle\Entity\Ubicacion',
                    'choice_label' => 'descripcion',
                    'query_builder' => function (\Basso\VisualCalBundle\Repository\UbicacionRepository $er) {
                        return $er->createQueryBuilder('d')
                        ->orderBy('d.descripcion', 'ASC');
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
