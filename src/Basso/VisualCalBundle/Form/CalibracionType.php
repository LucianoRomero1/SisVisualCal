<?php

namespace Basso\VisualCalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CalibracionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'label' => 'Fecha',
                'attr' => [ 'readonly' => false ],
                'required' => true
            ))
            ->add('gage', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Gage',
                'choice_label' => 'id',
                'placeholder' => 'Elija una Opción',
                'empty_data' => null,
                'required' => true,
                'label' => 'Instrumento'
            )) 
            ->add('realizadaPor', TextType::class, array (
                'label' => 'Realizado Por',
                'required' => true
                ))
            ->add('pasa')
            ->add('temperatura', TextType::class, array (
                'label' => 'Temperatura',
                'required' => true
                ))
            ->add('humedad', TextType::class, array (
                'label' => 'Humedad',
                'required' => true
                ))
            ->add('almacen', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Almacen',
                'choice_label' => 'descripcion',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\AlmacenRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'placeholder' => 'Elija una Opción',
                'empty_data' => null,
                'required' => true,
                'label' => 'Almacen de Calibración'
            )) 
            ->add('ubicacion', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Ubicacion',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\UbicacionRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Ubicación',
                'mapped' => false,
            )) 
            ->add('calibracionTipo', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\CalibracionTipo',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'empty_data' => null,
                'required' => true,
                'label' => 'Tipo de Control'
            ))
            ->add('gageTipo', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Tipo',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\TipoRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Color',
                'mapped' => false,
            )) 
            ->add('resultado', TextType::class, array (
                'label' => 'Resultado',
                'required' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Basso\VisualCalBundle\Entity\Calibracion'
        ));
    }
}
