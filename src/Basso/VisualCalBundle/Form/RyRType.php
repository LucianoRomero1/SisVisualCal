<?php

namespace Basso\VisualCalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
//use Symfony\Component\HttpFoundation\File\File;

class RyRType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('soloPdf')
            ->add('partNo', TextType::class, array (
                'label' => 'Nº Pieza',
                'required' => false
                ))
            ->add('partName', TextType::class, array (
                'label' => 'Desc. Pieza',
                'required' => false
                ))
            ->add('caracteristic', TextType::class, array (
                'label' => 'Características',
                'required' => false
                ))
            ->add('ryRTipo', EntityType::class, array(
                    'class' => 'Basso\VisualCalBundle\Entity\RyRTipo',
                    'choice_label' => 'descripcion',
                    'placeholder' => 'Elija una Opción',
                    'empty_data' => null,
                    'required' => true,
                    'label' => 'Tipo'
               ))
            ->add('fecha', DateType::class, array(
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
                'label' => 'Fecha',
                'attr' => [ 'readonly' => false ],
                'required' => true
            ))
            ->add('trials', TextType::class, array (
                'label' => 'Pruebas',
                'required' => false
                ))
            ->add('ops', TextType::class, array (
                'label' => 'Operadores',
                'required' => false
                ))
            ->add('usl', NumberType::class, array (
                'label' => 'Lím. Superior',
                'attr' => array('step' => '0.001',),
                'required' => false
                ))
            ->add('lsl', NumberType::class, array (
                'label' => 'Lím. Inferior',
                'attr' => array('step' => '0.001',),
                'required' => false
                ))
            /*inicio repetibilidad */
            ->add('ev', NumberType::class, array (
                'label' => 'VE',
                'attr' => array('step' => '0.0001','readonly' => true),
                'required' => false,
                ) )
            ->add('evtolPorc', NumberType::class, array (
                'label' => '%Tol.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
                ))
            ->add('evtvPorc', NumberType::class, array (
                'label' => '%VT.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
            ))
            /*fin repetibilidad */    

            /*inicio reproducibilidad */
            ->add('av', NumberType::class, array (
                'label' => 'VEval',
                'required' => false,
                'attr' => array ('step' => '0.0001','readonly' => true )
                ))
            ->add('avtolPorc', NumberType::class, array (
                'label' => '%Tol.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
                ))
            ->add('avtvPorc', NumberType::class, array (
                'label' => '%VT.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
                ))
            /*fin reproducibilidad */
            
            /*inicio variacion pieza */    
            ->add('pv', NumberType::class, array (
                'label' => 'VP.',
                'required' => false,
                'attr' => array ('step' => '0.0001','readonly' => true )
                ))
            ->add('pvtolPorc', NumberType::class, array (
                'label' => '%Tol.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
                ))
            ->add('pvtvPorc', NumberType::class, array (
                'label' => '%VT.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
                ))
            /*fin variacion pieza */ 
            
            /*inicio var total */  
            ->add('rBar', NumberType::class, array (
                'label' => 'BARRA R',
                'required' => false,
                'attr' => array ('step' => '0.0001', 'readonly' => true )
                ))
            ->add('uclR', NumberType::class, array (
                'label' => 'LSC-R',
                'required' => false,
                'attr' => array ('step' => '0.0001','readonly' => true )
                ))
            ->add('tv', NumberType::class, array (
                'label' => 'VT.',
                'required' => false,
                'attr' => array ('step' => '0.0001','readonly' => true )
                ))
            /*fin var total */  

            /*inicio ryr instr */  
            ->add('rr', NumberType::class, array (
                'label' => 'RyR',
                'required' => false,
                'attr' => array ('step' => '0.0001','readonly' => true )
                ))
            ->add('rrtolPorc', NumberType::class, array (
                'label' => '%Tol.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
                ))

            ->add('rrtvPorc', NumberType::class, array (
                'label' => '%VT.',
                'required' => false,
                'attr' => array ('step' => '0.1','readonly' => true )
                ))
            /*fin ryr instr */  
            ->add('memo', TextType::class, array (
                'label' => 'Comentarios',
                'required' => false
                ))
            ->add('a11', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a12', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a13', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a14', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a15', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a16', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a17', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a18', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a19', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a110', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a21', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a22', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a23', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a24', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a25', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a26', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a27', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a28', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a29', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a210', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a31', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a32', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a33', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a34', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a35', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a36', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a37', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a38', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a39', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('a310', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b11', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b12', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b13', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b14', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b15', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b16', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b17', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b18', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b19', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b110', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b21', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b22', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b23', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b24', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b25', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b26', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b27', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b28', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b29', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b210', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b31', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b32', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b33', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b34', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b35', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b36', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b37', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b38', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b39', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('b310', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c11', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c12', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c13', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c14', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c15', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c16', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c17', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c18', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c19', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c110', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c21', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c22', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c23', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c24', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c25', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c26', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c27', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c28', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c29', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c210', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c31', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c32', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c33', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c34', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c35', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c36', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c37', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c38', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c39', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('c310', NumberType::class, ['attr' => array('step' => '0.001',), 'required' => false])
            ->add('nameA', TextType::class, array (
                'label' => 'Operador A',
                'required' => false
                ))
            ->add('nameB', TextType::class, array (
                'label' => 'Operador B',
                'required' => false
                ))
            ->add('nameC', TextType::class, array (
                'label' => 'Operador C',
                'required' => false
                ))
            ->add('gage', EntityType::class, array(
                'class' => 'Basso\VisualCalBundle\Entity\Gage',
                'choice_label' => 'id',
                'placeholder' => 'Please choose',
                'empty_data' => null,
                'required' => false,
                'label' => 'Instrumento'
            )) 
            ->add('rutaArchivo', TextType::class, array (
                'label' => 'Archivo PDF',
                'required' => false
                ))
            /*->add('rutas', FileType::class, [
                    "label" => "Archivo PDF",
                    "multiple" => false,
                    "mapped" => false,
                    "required" => false,
                    "constraints" => [
                        new All([
                            new File([
                                "maxSize" => "10M",
                                "mimeTypes" => [
                                    "application/pdf",
                                    "application/x-pdf"
                                ],
                                "mimeTypesMessage" => "Seleccione archivo PDF válido"
                            ])
                        ])
                    ]
                ])*/
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Basso\VisualCalBundle\Entity\RyR'
        ));
    }
}
