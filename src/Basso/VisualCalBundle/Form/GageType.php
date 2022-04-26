<?php

namespace Basso\VisualCalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('patronRef')
            ->add('nroCertificado', TextType::class, array (
                'label' => 'Nº Certificado',
                'required' => false
                ))
            ->add('nroSerie', TextType::class, array (
                'label' => 'Nº Serie',
                'required' => false
                ))
            ->add('nroCuenta', TextType::class, array (
                'label' => 'Nº Cuenta',
                'required' => false
                ))
            ->add('nroModelo', TextType::class, array (
                'label' => 'Nº Modelo',
                'required' => false
                ))
            ->add('descripcion', TextType::class, array (
                'label' => 'Descripción',
                'required' => true
                ))
            ->add('nroPlano', TextType::class, array (
                'label' => 'Nº Plano',
                'required' => false
                ))
            ->add('fechaPlano', DateType::class, array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'label' => 'Fecha Plano',
                'attr' => [ 'readonly' => false ], 
                'required' => false
            ))
            ->add('nivelCambio', TextType::class, array (
                'label' => 'Nivel Cambio',
                'required' => false
                ))
            ->add('fechaCambio', DateType::class, array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'label' => 'Fecha Cambio',
                'attr' => [ 'readonly' => false ],
                'required' => false
            ))
            ->add('notas', TextType::class, array (
                'label' => 'Notas',
                'required' => false
                ))
            ->add('fechaServicio', DateType::class, array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'label' => 'Fecha Servicio',
                'attr' => [ 'readonly' => false ],
                'required' => false
            ))
            ->add('fechaRetiro', DateType::class, array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'label' => 'Fecha Retiro',
                'attr' => [ 'readonly' => false ],
                'required' => false
            ))
            ->add('proveedor', TextType::class, array (
                'label' => 'Proveedor',
                'required' => false
                ))
            ->add('costo', TextType::class, array (
                'label' => 'Costo',
                'required' => false
                ))
            ->add('fechaCompra', DateType::class, array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'label' => 'Fecha Compra',
                'attr' => [ 'readonly' => false ],
                'required' => false
            ))
            ->add('otraInfo', TextType::class, array (
                'label' => 'Otra Inf.',
                'required' => false
                ))
            ->add('resolucion', TextType::class, array (
                'label' => 'Resolución',
                'required' => false
                ))
            ->add('toleranciaPos', TextType::class, array (
                'label' => '+ Tolerancia',
                'required' => false
                ))
            ->add('toleranciaNeg', TextType::class, array (
                'label' => '- Tolerancia',
                'required' => false
                ))
            ->add('incertidumbre', TextType::class, array (
                'label' => 'Incertidumbre',
                'required' => false
                ))
            ->add('calUso', TextType::class, array (
                'label' => 'Tiempo Inicial uso',
                'required' => false
                ))
            ->add('calibrador', TextType::class, array (
                'label' => 'Calibrador',
                'required' => false
                ))
            ->add('ultCalibrador', TextType::class, array (
                'label' => 'Ultima calibración por',
                'required' => false
                ))
            ->add('calFrecuencia', TextType::class, array (
                'label' => 'Frecuencia',
                'required' => false
                ))
            ->add('calHoras', TextType::class, array (
                'label' => 'Hrs. calibración',
                'required' => false
                ))
            /*->add('calUltimaFecha', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => 'Ultima Calibración',
                'attr' => [ 'readonly' => false ],
                'required' => false
            ))
            ->add('calProximaFecha', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => 'Próxima Calibración',
                'attr' => [ 'readonly' => true ],
                'required' => false
            ))*/
            ->add('rrFrecuencia', TextType::class, array (
                'label' => 'Frecuencia',
                'required' => false
                ))
            ->add('rrResultado', TextType::class, array (
                'label' => 'Ultimo Resultado',
                'required' => false
                ))
            /*->add('rrUltimaFecha', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => 'Ultima RR',
                'attr' => [ 'readonly' => true ],
                'required' => false
            ))
            ->add('rrProximaFecha', DateType::class, array(
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'label' => 'Próxima RR',
                'attr' => [ 'readonly' => true ],
                'required' => false
            ))*/
            ->add('estado', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Estado',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\EstadoRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => true
 
            )) 
            ->add('tipo', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Tipo',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\TipoRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => true,
                'label' => 'Color'       
            )) 
            ->add('gageUOM', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\GageUOM',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\GageUOMRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Unid. Medida'
 
            )) 
            ->add('almacen', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Almacen',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\AlmacenRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Almacén'
 
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
                'label' => 'Ubicación'
 
            )) 
            ->add('fabricante', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Fabricante',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\FabricanteRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Fabricante'
 
            )) 
            ->add('owner', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Owner',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\OwnerRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Dueño'
 
            )) 
            ->add('calFrecuenciaUM', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\UnidMedida',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\UnidMedidaRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->where("d.unidMp IS NOT NULL")
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Medida'
 
            )) 
            ->add('rrFrecuenciaUM', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\UnidMedida',
                'choice_label' => 'descripcion',
                'placeholder' => 'Elija una Opción',
                'query_builder' => function (\Basso\VisualCalBundle\Repository\UnidMedidaRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.descripcion', 'ASC');
                    },
                'empty_data' => null,
                'required' => false,
                'label' => 'Medida'
 
            )) 
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Basso\VisualCalBundle\Entity\Gage'
        ));
    }
}
