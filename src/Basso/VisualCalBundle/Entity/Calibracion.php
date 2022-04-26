<?php

namespace Basso\VisualCalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Calibracion
 *
 * @ORM\Table(name="neosys.vcal_calibracion")
 * @ORM\Entity(repositoryClass="Basso\VisualCalBundle\Repository\CalibracionRepository")
 */
class Calibracion
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
     * @ORM\ManyToOne(targetEntity="Gage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gage_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $gage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;
    
    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Almacen")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="almacen_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $almacen;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="CalibracionTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="calibracion_Tipo_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $calibracionTipo;

    /**
     * @var string
     *
     * @ORM\Column(name="realizadaPor", type="string", length=50)
     */
    private $realizadaPor;

    /**
     * @var bool
     *
     * @ORM\Column(name="pasa", type="boolean")
     */
    private $pasa;

    /**
     * @var string
     *
     * @ORM\Column(name="temperatura", type="string", length=50, nullable=true)
     */
    private $temperatura;

    /**
     * @var string
     *
     * @ORM\Column(name="humedad", type="string", length=50, nullable=true)
     */
    private $humedad;

    /**
     * @var string
     *
     * @ORM\Column(name="resultado", type="string", length=50, nullable=true)
     */
    private $resultado;

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
     * Set gage
     *
     * @param \Gage $gage
     *
     * @return Calibracion
     */
    public function setGage(\Basso\VisualCalBundle\Entity\Gage $gage = null)
    {
        $this->gage = $gage;

        return $this;
    }

    /**
     * Get gage
     *
     * @return \Gage
     */
    public function getGage()
    {
        return $this->gage;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Gage
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fechaCompra
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set almacen
     *
     * @param \Almacen $almacen
     *
     * @return Calibracion
     */
    public function setAlmacen(\Basso\VisualCalBundle\Entity\Almacen $almacen = null)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen
     *
     * @return \Almacen
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * Set calibracionTipo
     *
     * @param \CalibracionTipo $calibracionTipo
     *
     * @return Calibracion
     */
    public function setCalibracionTipo(\Basso\VisualCalBundle\Entity\CalibracionTipo $calibracionTipo = null)
    {
        $this->calibracionTipo = $calibracionTipo;

        return $this;
    }

    /**
     * Get calibracionTipo
     *
     * @return \CalibracionTipo
     */
    public function getCalibracionTipo()
    {
        return $this->calibracionTipo;
    }

    /**
     * Set realizadaPor
     *
     * @param string $realizadaPor
     *
     * @return Calibracion
     */
    public function setRealizadaPor($realizadaPor)
    {
        $this->realizadaPor = $realizadaPor;

        return $this;
    }

    /**
     * Get realizadaPor
     *
     * @return string
     */
    public function getRealizadaPor()
    {
        return $this->realizadaPor;
    }

    /**
     * Set pasa
     *
     * @param boolean $pasa
     *
     * @return Calibracion
     */
    public function setPasa($pasa)
    {
        $this->pasa = $pasa;

        return $this;
    }

    /**
     * Get pasa
     *
     * @return bool
     */
    public function getPasa()
    {
        return $this->pasa;
    }

    /**
     * Set temperatura
     *
     * @param string $temperatura
     *
     * @return Calibracion
     */
    public function setTemperatura($temperatura)
    {
        $this->temperatura = $temperatura;

        return $this;
    }

    /**
     * Get temperatura
     *
     * @return string
     */
    public function getTemperatura()
    {
        return $this->temperatura;
    }

    /**
     * Set humedad
     *
     * @param string $humedad
     *
     * @return Calibracion
     */
    public function setHumedad($humedad)
    {
        $this->humedad = $humedad;

        return $this;
    }

    /**
     * Get humedad
     *
     * @return string
     */
    public function getHumedad()
    {
        return $this->humedad;
    }

    /**
     * Set resultado
     *
     * @param string $resultado
     *
     * @return Calibracion
     */
    public function setResultado($resultado)
    {
        $this->resultado = $resultado;

        return $this;
    }

    /**
     * Get humedad
     *
     * @return string
     */
    public function getResultado()
    {
        return $this->resultado;
    }    
}

