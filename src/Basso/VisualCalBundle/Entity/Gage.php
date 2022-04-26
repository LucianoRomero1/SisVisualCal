<?php

namespace Basso\VisualCalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gage
 *
 * @ORM\Table(name="neosys.vcal_gage")
 * @ORM\Entity(repositoryClass="Basso\VisualCalBundle\Repository\GageRepository")
 */
class Gage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="string", length=50)
     * @ORM\Id
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Estado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estado_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $estado;

    /**
     * @var bool
     *
     * @ORM\Column(name="patronRef", type="boolean")
     */
    private $patronRef;

    /**
     * @var string
     *
     * @ORM\Column(name="nroCertificado", type="string", length=50, nullable=true)
     */
    private $nroCertificado;

    /**
     * @var string
     *
     * @ORM\Column(name="nroSerie", type="string", length=50, nullable=true)
     */
    private $nroSerie;

    /**
     * @var string
     *
     * @ORM\Column(name="nroCuenta", type="string", length=50, nullable=true)
     */
    private $nroCuenta;

    /**
     * @var string
     *
     * @ORM\Column(name="nroModelo", type="string", length=50, nullable=true)
     */
    private $nroModelo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=50, nullable=true)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Tipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $tipo;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="GageUOM")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="gage_uom_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $gageUOM;

    /**
     * @var string
     *
     * @ORM\Column(name="nroPlano", type="string", length=50, nullable=true)
     */
    private $nroPlano;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaPlano", type="datetime", nullable=true)
     */
    private $fechaPlano;

    /**
     * @var string
     *
     * @ORM\Column(name="nivelCambio", type="string", length=50, nullable=true)
     */
    private $nivelCambio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCambio", type="datetime", nullable=true)
     */
    private $fechaCambio;

    /**
     * @var string
     *
     * @ORM\Column(name="notas", type="string", length=250, nullable=true)
     */
    private $notas;

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
     * @ORM\ManyToOne(targetEntity="Ubicacion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ubicacion_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $ubicacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaServicio", type="datetime", nullable=true)
     */
    private $fechaServicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRetiro", type="datetime", nullable=true)
     */
    private $fechaRetiro;

    /**
     * @var string
     *
     * @ORM\Column(name="proveedor", type="string", length=50, nullable=true)
     */
    private $proveedor;

    /**
     * @var string
     *
     * @ORM\Column(name="costo", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $costo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCompra", type="datetime", nullable=true)
     */
    private $fechaCompra;

    /**
     * @var string
     *
     * @ORM\Column(name="otraInfo", type="string", length=50, nullable=true)
     */
    private $otraInfo;

    /**
     * @var \Fabricante
     *
     * @ORM\ManyToOne(targetEntity="Fabricante")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fabricante_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $fabricante;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Owner")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="owner_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="resolucion", type="string", length=50, nullable=true)
     */
    private $resolucion;

    /**
     * @var string
     *
     * @ORM\Column(name="toleranciaPos", type="string", length=50, nullable=true)
     */
    private $toleranciaPos;

    /**
     * @var string
     *
     * @ORM\Column(name="toleranciaNeg", type="string", length=50, nullable=true)
     */
    private $toleranciaNeg;

    /**
     * @var string
     *
     * @ORM\Column(name="usuarioM", type="string", length=20)
     */
    private $usuarioM;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaM", type="datetime")
     */
    private $fechaM;

    /**
     * @var string
     *
     * @ORM\Column(name="cal_uso", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $calUso;

    /**
     * @var string
     *
     * @ORM\Column(name="calibrador", type="string", length=50, nullable=true)
     */
    private $calibrador;    

    /**
     * @var string
     *
     * @ORM\Column(name="ult_calibrador", type="string", length=50, nullable=true)
     */
    private $ultCalibrador;   

    /**
     * @var string
     *
     * @ORM\Column(name="cal_frecuencia", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $calFrecuencia;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="UnidMedida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cal_frecuencia_um", referencedColumnName="cod_unidmedida", nullable=true)
     * })
     */
    private $calFrecuenciaUM;

    /**
     * @var string
     *
     * @ORM\Column(name="cal_horas", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $calHoras;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cal_ult_fecha", type="datetime", nullable=true)
     */
    private $calUltimaFecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cal_proxima_fecha", type="datetime", nullable=true)
     */
    private $calProximaFecha;
    
    /**
     * @var string
     *
     * @ORM\Column(name="rr_frecuencia", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $rrFrecuencia;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="UnidMedida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rr_frecuencia_um", referencedColumnName="cod_unidmedida", nullable=true)
     * })
     */
    private $rrFrecuenciaUM;

    /**
     * @var string
     *
     * @ORM\Column(name="rr_resultado", type="string", length=50, nullable=true)
     */
    private $rrResultado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rr_ult_fecha", type="datetime", nullable=true)
     */
    private $rrUltimaFecha;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="rr_proxima_fecha", type="datetime", nullable=true)
     */
    private $rrProximaFecha;

    /**
     * @var string
     *
     * @ORM\Column(name="incertidumbre", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $incertidumbre;

    /**
     * Set id
     *
     * @param string $id
     *
     * @return Gage
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set estado
     *
     * @param \Estado $estado
     *
     * @return Gage
     */
    public function setEstado(\Basso\VisualCalBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \Estado
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set patronRef
     *
     * @param boolean $patronRef
     *
     * @return Gage
     */
    public function setPatronRef($patronRef)
    {
        $this->patronRef = $patronRef;

        return $this;
    }

    /**
     * Get patronRef
     *
     * @return bool
     */
    public function getPatronRef()
    {
        return $this->patronRef;
    }

    /**
     * Set nroCertificado
     *
     * @param string $nroCertificado
     *
     * @return Gage
     */
    public function setNroCertificado($nroCertificado)
    {
        $this->nroCertificado = $nroCertificado;

        return $this;
    }

    /**
     * Get nroCertificado
     *
     * @return string
     */
    public function getNroCertificado()
    {
        return $this->nroCertificado;
    }

    /**
     * Set nroSerie
     *
     * @param string $nroSerie
     *
     * @return Gage
     */
    public function setNroSerie($nroSerie)
    {
        $this->nroSerie = $nroSerie;

        return $this;
    }

    /**
     * Get nroSerie
     *
     * @return string
     */
    public function getNroSerie()
    {
        return $this->nroSerie;
    }

    /**
     * Set nroCuenta
     *
     * @param string $nroCuenta
     *
     * @return Gage
     */
    public function setNroCuenta($nroCuenta)
    {
        $this->nroCuenta = $nroCuenta;

        return $this;
    }

    /**
     * Get nroCuenta
     *
     * @return string
     */
    public function getNroCuenta()
    {
        return $this->nroCuenta;
    }

    /**
     * Set nroModelo
     *
     * @param string $nroModelo
     *
     * @return Gage
     */
    public function setNroModelo($nroModelo)
    {
        $this->nroModelo = $nroModelo;

        return $this;
    }

    /**
     * Get nroModelo
     *
     * @return string
     */
    public function getNroModelo()
    {
        return $this->nroModelo;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Gage
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

    /**
     * Set tipo
     *
     * @param \Tipo $tipo
     *
     * @return Gage
     */
    public function setTipo(\Basso\VisualCalBundle\Entity\Tipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return \stdClass
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set gageUOM
     *
     * @param \GageUOM $gageUOM
     *
     * @return Gage
     */
    public function setGageUOM(\Basso\VisualCalBundle\Entity\GageUOM $gageUOM = null )
    {
        $this->gageUOM = $gageUOM;

        return $this;
    }

    /**
     * Get gageUOM
     *
     * @return \gageUOM
     */
    public function getGageUOM()
    {
        return $this->gageUOM;
    }

    /**
     * Set nroPlano
     *
     * @param string $nroPlano
     *
     * @return Gage
     */
    public function setNroPlano($nroPlano)
    {
        $this->nroPlano = $nroPlano;

        return $this;
    }

    /**
     * Get nroPlano
     *
     * @return string
     */
    public function getNroPlano()
    {
        return $this->nroPlano;
    }

    /**
     * Set fechaPlano
     *
     * @param \DateTime $fechaPlano
     *
     * @return Gage
     */
    public function setFechaPlano($fechaPlano)
    {
        $this->fechaPlano = $fechaPlano;

        return $this;
    }

    /**
     * Get fechaPlano
     *
     * @return \DateTime
     */
    public function getFechaPlano()
    {
        return $this->fechaPlano;
    }

    /**
     * Set nivelCambio
     *
     * @param string $nivelCambio
     *
     * @return Gage
     */
    public function setNivelCambio($nivelCambio)
    {
        $this->nivelCambio = $nivelCambio;

        return $this;
    }

    /**
     * Get nivelCambio
     *
     * @return string
     */
    public function getNivelCambio()
    {
        return $this->nivelCambio;
    }

    /**
     * Set fechaCambio
     *
     * @param \DateTime $fechaCambio
     *
     * @return Gage
     */
    public function setFechaCambio($fechaCambio)
    {
        $this->fechaCambio = $fechaCambio;

        return $this;
    }

    /**
     * Get fechaCambio
     *
     * @return \DateTime
     */
    public function getFechaCambio()
    {
        return $this->fechaCambio;
    }

    /**
     * Set notas
     *
     * @param string $notas
     *
     * @return Gage
     */
    public function setNotas($notas)
    {
        $this->notas = $notas;

        return $this;
    }

    /**
     * Get notas
     *
     * @return string
     */
    public function getNotas()
    {
        return $this->notas;
    }

    /**
     * Set almacen
     *
     * @param \stdClass $almacen
     *
     * @return Gage
     */
    public function setAlmacen(\Basso\VisualCalBundle\Entity\Almacen $almacen = null )
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
     * Set ubicacion
     *
     * @param \Ubicacion $ubicacion
     *
     * @return Gage
     */
    public function setUbicacion(\Basso\VisualCalBundle\Entity\Ubicacion $ubicacion = null )
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return \Ubicacion
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }

    /**
     * Set fechaServicio
     *
     * @param \DateTime $fechaServicio
     *
     * @return Gage
     */
    public function setFechaServicio($fechaServicio)
    {
        $this->fechaServicio = $fechaServicio;

        return $this;
    }

    /**
     * Get fechaServicio
     *
     * @return \DateTime
     */
    public function getFechaServicio()
    {
        return $this->fechaServicio;
    }

    /**
     * Set fechaRetiro
     *
     * @param \DateTime $fechaRetiro
     *
     * @return Gage
     */
    public function setFechaRetiro($fechaRetiro)
    {
        $this->fechaRetiro = $fechaRetiro;

        return $this;
    }

    /**
     * Get fechaRetiro
     *
     * @return \DateTime
     */
    public function getFechaRetiro()
    {
        return $this->fechaRetiro;
    }


    /**
     * Set proveedor
     *
     * @param string $proveedor
     *
     * @return Gage
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    /**
     * Get proveedor
     *
     * @return string
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * Set costo
     *
     * @param string $costo
     *
     * @return Gage
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return string
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set fechaCompra
     *
     * @param \DateTime $fechaCompra
     *
     * @return Gage
     */
    public function setFechaCompra($fechaCompra)
    {
        $this->fechaCompra = $fechaCompra;

        return $this;
    }

    /**
     * Get fechaCompra
     *
     * @return \DateTime
     */
    public function getFechaCompra()
    {
        return $this->fechaCompra;
    }

    /**
     * Set otraInfo
     *
     * @param string $otraInfo
     *
     * @return Gage
     */
    public function setOtraInfo($otraInfo)
    {
        $this->otraInfo = $otraInfo;

        return $this;
    }

    /**
     * Get otraInfo
     *
     * @return string
     */
    public function getOtraInfo()
    {
        return $this->otraInfo;
    }

    /**
     * Set fabricante
     *
     * @param \Fabricante $fabricante
     *
     * @return Gage
     */
    public function setFabricante(\Basso\VisualCalBundle\Entity\Fabricante $fabricante = null )
    {
        $this->fabricante = $fabricante;

        return $this;
    }

    /**
     * Get fabricante
     *
     * @return \Fabricante
     */
    public function getFabricante()
    {
        return $this->fabricante;
    }

    /**
     * Set owner
     *
     * @param \Owner $owner
     *
     * @return Gage
     */
    public function setOwner(\Basso\VisualCalBundle\Entity\Owner $owner = null )
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set resolucion
     *
     * @param string $resolucion
     *
     * @return Gage
     */
    public function setResolucion($resolucion)
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    /**
     * Get resolucion
     *
     * @return string
     */
    public function getResolucion()
    {
        return $this->resolucion;
    }

    /**
     * Set toleranciaPos
     *
     * @param string $toleranciaPos
     *
     * @return Gage
     */
    public function setToleranciaPos($toleranciaPos)
    {
        $this->toleranciaPos = $toleranciaPos;

        return $this;
    }

    /**
     * Get toleranciaPos
     *
     * @return string
     */
    public function getToleranciaPos()
    {
        return $this->toleranciaPos;
    }

    /**
     * Set toleranciaNeg
     *
     * @param string $toleranciaNeg
     *
     * @return Gage
     */
    public function setToleranciaNeg($toleranciaNeg)
    {
        $this->toleranciaNeg = $toleranciaNeg;

        return $this;
    }

    /**
     * Get toleranciaNeg
     *
     * @return string
     */
    public function getToleranciaNeg()
    {
        return $this->toleranciaNeg;
    }

    /**
     * Set usuarioM
     *
     * @param string $usuarioM
     *
     * @return Gage
     */
    public function setUsuarioM($usuarioM)
    {
        $this->usuarioM = $usuarioM;

        return $this;
    }

    /**
     * Get usuarioM
     *
     * @return string
     */
    public function getUsuarioM()
    {
        return $this->usuarioM;
    }

    /**
     * Set fechaM
     *
     * @param \DateTime $fechaM
     *
     * @return Gage
     */
    public function setFechaM($fechaM)
    {
        $this->fechaM = $fechaM;

        return $this;
    }

    /**
     * Get fechaM
     *
     * @return \DateTime
     */
    public function getFechaM()
    {
        return $this->fechaM;
    }

    /**
     * Set calUso
     *
     * @param string $calUso
     *
     * @return Gage
     */
    public function setCalUso($calUso)
    {
        $this->calUso = $calUso;

        return $this;
    }

    /**
     * Get calUso
     *
     * @return string
     */
    public function getCalUso()
    {
        return $this->calUso;
    }

    /**
     * Set calibrador
     *
     * @param \Calibrador $calibrador
     *
     * @return Gage
     */
    public function setCalibrador($calibrador)
    {
        $this->calibrador = $calibrador;

        return $this;
    }

    /**
     * Get calibrador
     *
     * @return \Calibrador
     */
    public function getCalibrador()
    {
        return $this->calibrador;
    }

    /**
     * Set ultCalibrador
     *
     * @param \Calibrador $ultCalibrador
     *
     * @return Gage
     */
    public function setUltCalibrador($ultCalibrador)
    {
        $this->ultCalibrador = $ultCalibrador;

        return $this;
    }

    /**
     * Get calibrador
     *
     * @return \Calibrador
     */
    public function getUltCalibrador()
    {
        return $this->ultCalibrador;
    }

    /**
     * Set calFrecuencia
     *
     * @param string $calFrecuencia
     *
     * @return Gage
     */
    public function setCalFrecuencia($calFrecuencia)
    {
        $this->calFrecuencia = $calFrecuencia;

        return $this;
    }

    /**
     * Get calFrecuencia
     *
     * @return string
     */
    public function getCalFrecuencia()
    {
        return $this->calFrecuencia;
    }

    /**
     * Set unidMedida
     *
     * @param \UnidMedida $calFrecuenciaUM
     *
     * @return Gage
     */
    public function setCalFrecuenciaUM(\Basso\VisualCalBundle\Entity\UnidMedida $calFrecuenciaUM = null)
    {
        $this->calFrecuenciaUM = $calFrecuenciaUM;

        return $this;
    }

    /**
     * Get UnidMedida
     *
     * @return \UnidMedida
     */
    public function getCalFrecuenciaUM()
    {
        return $this->calFrecuenciaUM;
    }

    /**
     * Set unidMedida
     *
     * @param \UnidMedida $calHoras
     *
     * @return Gage
     */
    public function setCalHoras( $calHoras)
    {
        $this->calHoras = $calHoras;

        return $this;
    }

    /**
     * Get UnidMedida
     *
     * @return \UnidMedida
     */
    public function getCalHoras()
    {
        return $this->calHoras;
    }

    /**
     * Set calUltimaFecha
     *
     * @param \DateTime $fechaM
     *
     * @return Gage
     */
    public function setCalUltimaFecha($calUltimaFecha)
    {
        $this->calUltimaFecha = $calUltimaFecha;

        return $this;
    }

    /**
     * Get calUltimaFecha
     *
     * @return \DateTime
     */
    public function getCalUltimaFecha()
    {
        return $this->calUltimaFecha;
    }

    /**
     * Set calProximaFecha
     *
     * @param \DateTime $calProximaFecha
     *
     * @return Gage
     */
    public function setCalProximaFecha($calProximaFecha)
    {
        $this->calProximaFecha = $calProximaFecha;

        return $this;
    }

    /**
     * Get calProximaFecha
     *
     * @return \DateTime
     */
    public function getCalProximaFecha()
    {
        return $this->calProximaFecha;
    }
    
    /**
     * Set unidMedida
     *
     * @param \UnidMedida $rrFrecuenciaUM
     *
     * @return Gage
     */
    public function setRrFrecuenciaUM(\Basso\VisualCalBundle\Entity\UnidMedida $rrFrecuenciaUM = null)
    {
        $this->rrFrecuenciaUM = $rrFrecuenciaUM;

        return $this;
    }

    /**
     * Get UnidMedida
     *
     * @return \UnidMedida
     */
    public function getRrFrecuenciaUM()
    {
        return $this->rrFrecuenciaUM;
    }

    /**
     * Set rrFrecuencia
     *
     * @param string $rrFrecuencia
     *
     * @return Gage
     */
    public function setRrFrecuencia($rrFrecuencia)
    {
        $this->rrFrecuencia = $rrFrecuencia;

        return $this;
    }

    /**
     * Get rrFrecuencia
     *
     * @return string
     */
    public function getRrFrecuencia()
    {
        return $this->rrFrecuencia;
    }

    /**
     * Set rrResultado
     *
     * @param string $rrResultado
     *
     * @return Gage
     */
    public function setRrResultado($rrResultado)
    {
        $this->rrResultado = $rrResultado;

        return $this;
    }

    /**
     * Get rrResultado
     *
     * @return string
     */
    public function getRrResultado()
    {
        return $this->rrResultado;
    }

    /**
     * Set rrUltimaFecha
     *
     * @param \DateTime $fechaM
     *
     * @return Gage
     */
    public function setRrUltimaFecha($rrUltimaFecha)
    {
        $this->rrUltimaFecha = $rrUltimaFecha;

        return $this;
    }

    /**
     * Get rrUltimaFecha
     *
     * @return \DateTime
     */
    public function getRrUltimaFecha()
    {
        return $this->rrUltimaFecha;
    }

    /**
     * Set rrProximaFecha
     *
     * @param \DateTime $rrProximaFecha
     *
     * @return Gage
     */
    public function setRrProximaFecha($rrProximaFecha)
    {
        $this->rrProximaFecha = $rrProximaFecha;

        return $this;
    }

    /**
     * Get rrProximaFecha
     *
     * @return \DateTime
     */
    public function getRrProximaFecha()
    {
        return $this->rrProximaFecha;
    }

    /**
     * Set unidMedida
     *
     * @param \UnidMedida $incertidumbre
     *
     * @return Gage
     */
    public function setIncertidumbre( $incertidumbre)
    {
        $this->incertidumbre = $incertidumbre;

        return $this;
    }

    /**
     * Get UnidMedida
     *
     * @return \UnidMedida
     */
    public function getIncertidumbre()
    {
        return $this->incertidumbre;
    }

    public function __toString()
    {
        return $this->id . ' - ' . $this->descripcion;
    }

}

