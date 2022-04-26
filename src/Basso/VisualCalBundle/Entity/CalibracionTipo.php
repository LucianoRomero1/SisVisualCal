<?php

namespace Basso\VisualCalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CalibracionTipo
 *
 * @ORM\Table(name="neosys.vcal_calibracion_tipo")
 * @ORM\Entity(repositoryClass="Basso\VisualCalBundle\Repository\CalibracionTipoRepository")
 */
class CalibracionTipo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="neosys.vcal_cal_tipo_seq")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50)
     */
    private $descripcion;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return CalibracionTipo
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}

