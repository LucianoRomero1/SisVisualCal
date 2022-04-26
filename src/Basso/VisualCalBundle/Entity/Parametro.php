<?php

namespace Basso\VisualCalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parametro
 *
 * @ORM\Table(name="neosys.vcal_parametro")
 * @ORM\Entity(repositoryClass="Basso\VisualCalBundle\Repository\ParametroRepository")
 */
class Parametro
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Almacen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="def_almacen_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $defAlmacen;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="CalibracionTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="def_calibracion_Tipo_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $defCalibracionTipo;


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
     * Set defAlmacen
     *
     * @param \stdClass $defAlmacen
     *
     * @return Parametro
     */
    public function setDefAlmacen(\Basso\VisualCalBundle\Entity\Almacen $defAlmacen = null )
    {
        $this->defAlmacen = $defAlmacen;

        return $this;
    }

    /**
     * Get defAlmacen
     *
     * @return \stdClass
     */
    public function getDefAlmacen()
    {
        return $this->defAlmacen;
    }

    /**
     * Set defCalibracionTipo
     *
     * @param \stdClass $defCalibracionTipo
     *
     * @return Parametro
     */
    public function setDefCalibracionTipo(\Basso\VisualCalBundle\Entity\CalibracionTipo $defCalibracionTipo = null )
    {
        $this->defCalibracionTipo = $defCalibracionTipo;

        return $this;
    }

    /**
     * Get defCalibracionTipo
     *
     * @return \stdClass
     */
    public function getDefCalibracionTipo()
    {
        return $this->defCalibracionTipo;
    }
}

