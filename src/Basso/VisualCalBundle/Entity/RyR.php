<?php

namespace Basso\VisualCalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RyR
 *
 * @ORM\Table(name="neosys.vcal_ryr")
 * @ORM\Entity(repositoryClass="Basso\VisualCalBundle\Repository\RyRRepository")
 */
class RyR
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
     * @var bool
     *
     * @ORM\Column(name="soloPdf", type="boolean")
     */
    private $soloPdf;

    /**
     * @var string
     *
     * @ORM\Column(name="partNo", type="string", length=25, nullable=true)
     */
    private $partNo;

    /**
     * @var string
     *
     * @ORM\Column(name="partName", type="string", length=25, nullable=true)
     */
    private $partName;

    /**
     * @var string
     *
     * @ORM\Column(name="caracteristic", type="string", length=25, nullable=true)
     */
    private $caracteristic;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="RyRTipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ryr_tipo_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $ryRTipo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="trials", type="string", length=2, nullable=true)
     */
    private $trials;

    /**
     * @var string
     *
     * @ORM\Column(name="ops", type="string", length=2, nullable=true)
     */
    private $ops;

    /**
     * @var string
     *
     * @ORM\Column(name="usl", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $usl;

    /**
     * @var string
     *
     * @ORM\Column(name="lsl", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $lsl;

    /**
     * @var string
     *
     * @ORM\Column(name="ev", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $ev;

    /**
     * @var string
     *
     * @ORM\Column(name="evtolPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $evtolPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="evtvPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $evtvPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="av", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $av;

    /**
     * @var string
     *
     * @ORM\Column(name="avtolPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $avtolPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="avtvPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $avtvPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="rr", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $rr;

    /**
     * @var string
     *
     * @ORM\Column(name="rrtolPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $rrtolPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="rrtvPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $rrtvPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="pv", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $pv;

    /**
     * @var string
     *
     * @ORM\Column(name="pvtolPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $pvtolPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="pvtvPorc", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $pvtvPorc;

    /**
     * @var string
     *
     * @ORM\Column(name="rBar", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $rBar;

    /**
     * @var string
     *
     * @ORM\Column(name="uclR", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $uclR;

    /**
     * @var string
     *
     * @ORM\Column(name="tv", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $tv;

    /**
     * @var string
     *
     * @ORM\Column(name="memo", type="string", length=255, nullable=true)
     */
    private $memo;

    /**
     * @var string
     *
     * @ORM\Column(name="a11", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a11;

    /**
     * @var string
     *
     * @ORM\Column(name="a12", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a12;

    /**
     * @var string
     *
     * @ORM\Column(name="a13", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a13;

    /**
     * @var string
     *
     * @ORM\Column(name="a14", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a14;

    /**
     * @var string
     *
     * @ORM\Column(name="a15", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a15;

    /**
     * @var string
     *
     * @ORM\Column(name="a16", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a16;

    /**
     * @var string
     *
     * @ORM\Column(name="a17", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a17;

    /**
     * @var string
     *
     * @ORM\Column(name="a18", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a18;

    /**
     * @var string
     *
     * @ORM\Column(name="a19", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a19;

    /**
     * @var string
     *
     * @ORM\Column(name="a110", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a110;

    /**
     * @var string
     *
     * @ORM\Column(name="a21", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a21;

    /**
     * @var string
     *
     * @ORM\Column(name="a22", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a22;

    /**
     * @var string
     *
     * @ORM\Column(name="a23", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a23;

    /**
     * @var string
     *
     * @ORM\Column(name="a24", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a24;

    /**
     * @var string
     *
     * @ORM\Column(name="a25", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a25;

    /**
     * @var string
     *
     * @ORM\Column(name="a26", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a26;

    /**
     * @var string
     *
     * @ORM\Column(name="a27", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a27;

    /**
     * @var string
     *
     * @ORM\Column(name="a28", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a28;

    /**
     * @var string
     *
     * @ORM\Column(name="a29", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a29;

    /**
     * @var string
     *
     * @ORM\Column(name="a210", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a210;

    /**
     * @var string
     *
     * @ORM\Column(name="a31", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a31;

    /**
     * @var string
     *
     * @ORM\Column(name="a32", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a32;

    /**
     * @var string
     *
     * @ORM\Column(name="a33", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a33;

    /**
     * @var string
     *
     * @ORM\Column(name="a34", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a34;

    /**
     * @var string
     *
     * @ORM\Column(name="a35", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a35;

    /**
     * @var string
     *
     * @ORM\Column(name="a36", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a36;

    /**
     * @var string
     *
     * @ORM\Column(name="a37", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a37;

    /**
     * @var string
     *
     * @ORM\Column(name="a38", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a38;

    /**
     * @var string
     *
     * @ORM\Column(name="a39", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a39;

    /**
     * @var string
     *
     * @ORM\Column(name="a310", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $a310;

    /**
     * @var string
     *
     * @ORM\Column(name="b11", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b11;

    /**
     * @var string
     *
     * @ORM\Column(name="b12", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b12;

    /**
     * @var string
     *
     * @ORM\Column(name="b13", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b13;

    /**
     * @var string
     *
     * @ORM\Column(name="b14", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b14;

    /**
     * @var string
     *
     * @ORM\Column(name="b15", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b15;

    /**
     * @var string
     *
     * @ORM\Column(name="b16", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b16;

    /**
     * @var string
     *
     * @ORM\Column(name="b17", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b17;

    /**
     * @var string
     *
     * @ORM\Column(name="b18", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b18;

    /**
     * @var string
     *
     * @ORM\Column(name="b19", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b19;

    /**
     * @var string
     *
     * @ORM\Column(name="b110", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b110;

    /**
     * @var string
     *
     * @ORM\Column(name="b21", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b21;

    /**
     * @var string
     *
     * @ORM\Column(name="b22", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b22;

    /**
     * @var string
     *
     * @ORM\Column(name="b23", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b23;

    /**
     * @var string
     *
     * @ORM\Column(name="b24", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b24;

    /**
     * @var string
     *
     * @ORM\Column(name="b25", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b25;

    /**
     * @var string
     *
     * @ORM\Column(name="b26", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b26;

    /**
     * @var string
     *
     * @ORM\Column(name="b27", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b27;

    /**
     * @var string
     *
     * @ORM\Column(name="b28", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b28;

    /**
     * @var string
     *
     * @ORM\Column(name="b29", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b29;

    /**
     * @var string
     *
     * @ORM\Column(name="b210", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b210;

    /**
     * @var string
     *
     * @ORM\Column(name="b31", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b31;

    /**
     * @var string
     *
     * @ORM\Column(name="b32", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b32;

    /**
     * @var string
     *
     * @ORM\Column(name="b33", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b33;

    /**
     * @var string
     *
     * @ORM\Column(name="b34", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b34;

    /**
     * @var string
     *
     * @ORM\Column(name="b35", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b35;

    /**
     * @var string
     *
     * @ORM\Column(name="b36", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b36;

    /**
     * @var string
     *
     * @ORM\Column(name="b37", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b37;

    /**
     * @var string
     *
     * @ORM\Column(name="b38", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b38;

    /**
     * @var string
     *
     * @ORM\Column(name="b39", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b39;

    /**
     * @var string
     *
     * @ORM\Column(name="b310", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $b310;

    /**
     * @var string
     *
     * @ORM\Column(name="c11", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c11;

    /**
     * @var string
     *
     * @ORM\Column(name="c12", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c12;

    /**
     * @var string
     *
     * @ORM\Column(name="c13", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c13;

    /**
     * @var string
     *
     * @ORM\Column(name="c14", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c14;

    /**
     * @var string
     *
     * @ORM\Column(name="c15", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c15;

    /**
     * @var string
     *
     * @ORM\Column(name="c16", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c16;

    /**
     * @var string
     *
     * @ORM\Column(name="c17", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c17;

    /**
     * @var string
     *
     * @ORM\Column(name="c18", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c18;

    /**
     * @var string
     *
     * @ORM\Column(name="c19", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c19;

    /**
     * @var string
     *
     * @ORM\Column(name="c110", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c110;

    /**
     * @var string
     *
     * @ORM\Column(name="c21", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c21;

    /**
     * @var string
     *
     * @ORM\Column(name="c22", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c22;

    /**
     * @var string
     *
     * @ORM\Column(name="c23", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c23;

    /**
     * @var string
     *
     * @ORM\Column(name="c24", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c24;

    /**
     * @var string
     *
     * @ORM\Column(name="c25", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c25;

    /**
     * @var string
     *
     * @ORM\Column(name="c26", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c26;

    /**
     * @var string
     *
     * @ORM\Column(name="c27", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c27;

    /**
     * @var string
     *
     * @ORM\Column(name="c28", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c28;

    /**
     * @var string
     *
     * @ORM\Column(name="c29", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c29;

    /**
     * @var string
     *
     * @ORM\Column(name="c210", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c210;

    /**
     * @var string
     *
     * @ORM\Column(name="c31", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c31;

    /**
     * @var string
     *
     * @ORM\Column(name="c32", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c32;

    /**
     * @var string
     *
     * @ORM\Column(name="c33", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c33;

    /**
     * @var string
     *
     * @ORM\Column(name="c34", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c34;

    /**
     * @var string
     *
     * @ORM\Column(name="c35", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c35;

    /**
     * @var string
     *
     * @ORM\Column(name="c36", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c36;

    /**
     * @var string
     *
     * @ORM\Column(name="c37", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c37;

    /**
     * @var string
     *
     * @ORM\Column(name="c38", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c38;

    /**
     * @var string
     *
     * @ORM\Column(name="c39", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c39;

    /**
     * @var string
     *
     * @ORM\Column(name="c310", type="decimal", precision=11, scale=5, nullable=true)
     */
    private $c310;

    /**
     * @var string
     *
     * @ORM\Column(name="nameA", type="string", length=20, nullable=true)
     */
    private $nameA;

    /**
     * @var string
     *
     * @ORM\Column(name="nameB", type="string", length=20, nullable=true)
     */
    private $nameB;

    /**
     * @var string
     *
     * @ORM\Column(name="nameC", type="string", length=20, nullable=true)
     */
    private $nameC;

    /**
     * @var string
     *
     * @ORM\Column(name="rutaArchivo", type="string", length=500, nullable=true)
     */
    private $rutaArchivo;

    /**
     * @var string
     *
     * @ORM\Column(name="usuarioM", type="string", length=25)
     */
    private $usuarioM;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaM", type="datetime")
     */
    private $fechaM;

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
     * @return RyR
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
     * Set soloPdf
     *
     * @param boolean $soloPdf
     *
     * @return RyR
     */
    public function setSoloPdf($soloPdf)
    {
        $this->soloPdf = $soloPdf;

        return $this;
    }

    /**
     * Get soloPdf
     *
     * @return bool
     */
    public function getSoloPdf()
    {
        return $this->soloPdf;
    }

    /**
     * Set partNo
     *
     * @param string $partNo
     *
     * @return RyR
     */
    public function setPartNo($partNo)
    {
        $this->partNo = $partNo;

        return $this;
    }

    /**
     * Get partNo
     *
     * @return string
     */
    public function getPartNo()
    {
        return $this->partNo;
    }

    /**
     * Set partName
     *
     * @param string $partName
     *
     * @return RyR
     */
    public function setPartName($partName)
    {
        $this->partName = $partName;

        return $this;
    }

    /**
     * Get partName
     *
     * @return string
     */
    public function getPartName()
    {
        return $this->partName;
    }

    /**
     * Set caracteristic
     *
     * @param string $caracteristic
     *
     * @return RyR
     */
    public function setCaracteristic($caracteristic)
    {
        $this->caracteristic = $caracteristic;

        return $this;
    }

    /**
     * Get caracteristic
     *
     * @return string
     */
    public function getCaracteristic()
    {
        return $this->caracteristic;
    }

    /**
     * Set ryRTipo
     *
     * @param \RyRTipo $ryRTipo
     *
     * @return RyR
     */
    public function setRyRTipo(\Basso\VisualCalBundle\Entity\RyRTipo $ryRTipo = null)
    {
        $this->ryRTipo = $ryRTipo;

        return $this;
    }

    /**
     * Get ryRTipo
     *
     * @return \RyRTipo
     */
    public function getRyRTipo()
    {
        return $this->ryRTipo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return RyR
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set trials
     *
     * @param string $trials
     *
     * @return RyR
     */
    public function setTrials($trials)
    {
        $this->trials = $trials;

        return $this;
    }

    /**
     * Get trials
     *
     * @return string
     */
    public function getTrials()
    {
        return $this->trials;
    }

    /**
     * Set ops
     *
     * @param string $ops
     *
     * @return RyR
     */
    public function setOps($ops)
    {
        $this->ops = $ops;

        return $this;
    }

    /**
     * Get ops
     *
     * @return string
     */
    public function getOps()
    {
        return $this->ops;
    }

    /**
     * Set usl
     *
     * @param string $usl
     *
     * @return RyR
     */
    public function setUsl($usl)
    {
        $this->usl = $usl;

        return $this;
    }

    /**
     * Get usl
     *
     * @return string
     */
    public function getUsl()
    {
        return $this->usl;
    }

    /**
     * Set lsl
     *
     * @param string $lsl
     *
     * @return RyR
     */
    public function setLsl($lsl)
    {
        $this->lsl = $lsl;

        return $this;
    }

    /**
     * Get lsl
     *
     * @return string
     */
    public function getLsl()
    {
        return $this->lsl;
    }

    /**
     * Set ev
     *
     * @param string $ev
     *
     * @return RyR
     */
    public function setEv($ev)
    {
        $this->ev = $ev;

        return $this;
    }

    /**
     * Get ev
     *
     * @return string
     */
    public function getEv()
    {
        return $this->ev;
    }

    /**
     * Set evtolPorc
     *
     * @param string $evtolPorc
     *
     * @return RyR
     */
    public function setEvtolPorc($evtolPorc)
    {
        $this->evtolPorc = $evtolPorc;

        return $this;
    }

    /**
     * Get evtolPorc
     *
     * @return string
     */
    public function getEvtolPorc()
    {
        return $this->evtolPorc;
    }

    /**
     * Set evtvPorc
     *
     * @param string $evtvPorc
     *
     * @return RyR
     */
    public function setEvtvPorc($evtvPorc)
    {
        $this->evtvPorc = $evtvPorc;

        return $this;
    }

    /**
     * Get evtvPorc
     *
     * @return string
     */
    public function getEvtvPorc()
    {
        return $this->evtvPorc;
    }

    /**
     * Set av
     *
     * @param string $av
     *
     * @return RyR
     */
    public function setAv($av)
    {
        $this->av = $av;

        return $this;
    }

    /**
     * Get av
     *
     * @return string
     */
    public function getAv()
    {
        return $this->av;
    }

    /**
     * Set avtolPorc
     *
     * @param string $avtolPorc
     *
     * @return RyR
     */
    public function setAvtolPorc($avtolPorc)
    {
        $this->avtolPorc = $avtolPorc;

        return $this;
    }

    /**
     * Get avtolPorc
     *
     * @return string
     */
    public function getAvtolPorc()
    {
        return $this->avtolPorc;
    }

    /**
     * Set avtvPorc
     *
     * @param string $avtvPorc
     *
     * @return RyR
     */
    public function setAvtvPorc($avtvPorc)
    {
        $this->avtvPorc = $avtvPorc;

        return $this;
    }

    /**
     * Get avtvPorc
     *
     * @return string
     */
    public function getAvtvPorc()
    {
        return $this->avtvPorc;
    }

    /**
     * Set rr
     *
     * @param string $rr
     *
     * @return RyR
     */
    public function setRr($rr)
    {
        $this->rr = $rr;

        return $this;
    }

    /**
     * Get rr
     *
     * @return string
     */
    public function getRr()
    {
        return $this->rr;
    }

    /**
     * Set rrtolPorc
     *
     * @param string $rrtolPorc
     *
     * @return RyR
     */
    public function setRrtolPorc($rrtolPorc)
    {
        $this->rrtolPorc = $rrtolPorc;

        return $this;
    }

    /**
     * Get rrtolPorc
     *
     * @return string
     */
    public function getRrtolPorc()
    {
        return $this->rrtolPorc;
    }

    /**
     * Set rrtvPorc
     *
     * @param string $rrtvPorc
     *
     * @return RyR
     */
    public function setRrtvPorc($rrtvPorc)
    {
        $this->rrtvPorc = $rrtvPorc;

        return $this;
    }

    /**
     * Get rrtvPorc
     *
     * @return string
     */
    public function getRrtvPorc()
    {
        return $this->rrtvPorc;
    }

    /**
     * Set pv
     *
     * @param string $pv
     *
     * @return RyR
     */
    public function setPv($pv)
    {
        $this->pv = $pv;

        return $this;
    }

    /**
     * Get pv
     *
     * @return string
     */
    public function getPv()
    {
        return $this->pv;
    }

    /**
     * Set pvtolPorc
     *
     * @param string $pvtolPorc
     *
     * @return RyR
     */
    public function setPvtolPorc($pvtolPorc)
    {
        $this->pvtolPorc = $pvtolPorc;

        return $this;
    }

    /**
     * Get pvtolPorc
     *
     * @return string
     */
    public function getPvtolPorc()
    {
        return $this->pvtolPorc;
    }

    /**
     * Set pvtvPorc
     *
     * @param string $pvtvPorc
     *
     * @return RyR
     */
    public function setPvtvPorc($pvtvPorc)
    {
        $this->pvtvPorc = $pvtvPorc;

        return $this;
    }

    /**
     * Get pvtvPorc
     *
     * @return string
     */
    public function getPvtvPorc()
    {
        return $this->pvtvPorc;
    }

    /**
     * Set rBar
     *
     * @param string $rBar
     *
     * @return RyR
     */
    public function setRBar($rBar)
    {
        $this->rBar = $rBar;

        return $this;
    }

    /**
     * Get rBar
     *
     * @return string
     */
    public function getRBar()
    {
        return $this->rBar;
    }

    /**
     * Set uclR
     *
     * @param string $uclR
     *
     * @return RyR
     */
    public function setUclR($uclR)
    {
        $this->uclR = $uclR;

        return $this;
    }

    /**
     * Get uclR
     *
     * @return string
     */
    public function getUclR()
    {
        return $this->uclR;
    }

    /**
     * Set tv
     *
     * @param string $tv
     *
     * @return RyR
     */
    public function setTv($tv)
    {
        $this->tv = $tv;

        return $this;
    }

    /**
     * Get tv
     *
     * @return string
     */
    public function getTv()
    {
        return $this->tv;
    }

    /**
     * Set memo
     *
     * @param string $memo
     *
     * @return RyR
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Get memo
     *
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set a11
     *
     * @param string $a11
     *
     * @return RyR
     */
    public function setA11($a11)
    {
        $this->a11 = $a11;

        return $this;
    }

    /**
     * Get a11
     *
     * @return string
     */
    public function getA11()
    {
        return $this->a11;
    }

    /**
     * Set a12
     *
     * @param string $a12
     *
     * @return RyR
     */
    public function setA12($a12)
    {
        $this->a12 = $a12;

        return $this;
    }

    /**
     * Get a12
     *
     * @return string
     */
    public function getA12()
    {
        return $this->a12;
    }

    /**
     * Set a13
     *
     * @param string $a13
     *
     * @return RyR
     */
    public function setA13($a13)
    {
        $this->a13 = $a13;

        return $this;
    }

    /**
     * Get a13
     *
     * @return string
     */
    public function getA13()
    {
        return $this->a13;
    }

    /**
     * Set a14
     *
     * @param string $a14
     *
     * @return RyR
     */
    public function setA14($a14)
    {
        $this->a14 = $a14;

        return $this;
    }

    /**
     * Get a14
     *
     * @return string
     */
    public function getA14()
    {
        return $this->a14;
    }

    /**
     * Set a15
     *
     * @param string $a15
     *
     * @return RyR
     */
    public function setA15($a15)
    {
        $this->a15 = $a15;

        return $this;
    }

    /**
     * Get a15
     *
     * @return string
     */
    public function getA15()
    {
        return $this->a15;
    }

    /**
     * Set a16
     *
     * @param string $a16
     *
     * @return RyR
     */
    public function setA16($a16)
    {
        $this->a16 = $a16;

        return $this;
    }

    /**
     * Get a16
     *
     * @return string
     */
    public function getA16()
    {
        return $this->a16;
    }

    /**
     * Set a17
     *
     * @param string $a17
     *
     * @return RyR
     */
    public function setA17($a17)
    {
        $this->a17 = $a17;

        return $this;
    }

    /**
     * Get a17
     *
     * @return string
     */
    public function getA17()
    {
        return $this->a17;
    }

    /**
     * Set a18
     *
     * @param string $a18
     *
     * @return RyR
     */
    public function setA18($a18)
    {
        $this->a18 = $a18;

        return $this;
    }

    /**
     * Get a18
     *
     * @return string
     */
    public function getA18()
    {
        return $this->a18;
    }

    /**
     * Set a19
     *
     * @param string $a19
     *
     * @return RyR
     */
    public function setA19($a19)
    {
        $this->a19 = $a19;

        return $this;
    }

    /**
     * Get a19
     *
     * @return string
     */
    public function getA19()
    {
        return $this->a19;
    }

    /**
     * Set a110
     *
     * @param string $a110
     *
     * @return RyR
     */
    public function setA110($a110)
    {
        $this->a110 = $a110;

        return $this;
    }

    /**
     * Get a110
     *
     * @return string
     */
    public function getA110()
    {
        return $this->a110;
    }
    
    /**
     * Set a21
     *
     * @param string $a21
     *
     * @return RyR
     */
    public function setA21($a21)
    {
        $this->a21 = $a21;

        return $this;
    }

    /**
     * Get a21
     *
     * @return string
     */
    public function getA21()
    {
        return $this->a21;
    }

    /**
     * Set a22
     *
     * @param string $a22
     *
     * @return RyR
     */
    public function setA22($a22)
    {
        $this->a22 = $a22;

        return $this;
    }

    /**
     * Get a22
     *
     * @return string
     */
    public function getA22()
    {
        return $this->a22;
    }

    /**
     * Set a23
     *
     * @param string $a23
     *
     * @return RyR
     */
    public function setA23($a23)
    {
        $this->a23 = $a23;

        return $this;
    }

    /**
     * Get a23
     *
     * @return string
     */
    public function getA23()
    {
        return $this->a23;
    }

    /**
     * Set a24
     *
     * @param string $a24
     *
     * @return RyR
     */
    public function setA24($a24)
    {
        $this->a24 = $a24;

        return $this;
    }

    /**
     * Get a24
     *
     * @return string
     */
    public function getA24()
    {
        return $this->a24;
    }

    /**
     * Set a25
     *
     * @param string $a25
     *
     * @return RyR
     */
    public function setA25($a25)
    {
        $this->a25 = $a25;

        return $this;
    }

    /**
     * Get a25
     *
     * @return string
     */
    public function getA25()
    {
        return $this->a25;
    }

    /**
     * Set a26
     *
     * @param string $a26
     *
     * @return RyR
     */
    public function setA26($a26)
    {
        $this->a26 = $a26;

        return $this;
    }

    /**
     * Get a26
     *
     * @return string
     */
    public function getA26()
    {
        return $this->a26;
    }

    /**
     * Set a27
     *
     * @param string $a27
     *
     * @return RyR
     */
    public function setA27($a27)
    {
        $this->a27 = $a27;

        return $this;
    }

    /**
     * Get a27
     *
     * @return string
     */
    public function getA27()
    {
        return $this->a27;
    }

    /**
     * Set a28
     *
     * @param string $a28
     *
     * @return RyR
     */
    public function setA28($a28)
    {
        $this->a28 = $a28;

        return $this;
    }

    /**
     * Get a28
     *
     * @return string
     */
    public function getA28()
    {
        return $this->a28;
    }

    /**
     * Set a29
     *
     * @param string $a29
     *
     * @return RyR
     */
    public function setA29($a29)
    {
        $this->a29 = $a29;

        return $this;
    }

    /**
     * Get a29
     *
     * @return string
     */
    public function getA29()
    {
        return $this->a29;
    }

    /**
     * Set a210
     *
     * @param string $a210
     *
     * @return RyR
     */
    public function setA210($a210)
    {
        $this->a210 = $a210;

        return $this;
    }

    /**
     * Get a210
     *
     * @return string
     */
    public function getA210()
    {
        return $this->a210;
    }
    
    /**
     * Set a31
     *
     * @param string $a31
     *
     * @return RyR
     */
    public function setA31($a31)
    {
        $this->a31 = $a31;

        return $this;
    }

    /**
     * Get a31
     *
     * @return string
     */
    public function getA31()
    {
        return $this->a31;
    }

    /**
     * Set a32
     *
     * @param string $a32
     *
     * @return RyR
     */
    public function setA32($a32)
    {
        $this->a32 = $a32;

        return $this;
    }

    /**
     * Get a32
     *
     * @return string
     */
    public function getA32()
    {
        return $this->a32;
    }

    /**
     * Set a33
     *
     * @param string $a33
     *
     * @return RyR
     */
    public function setA33($a33)
    {
        $this->a33 = $a33;

        return $this;
    }

    /**
     * Get a33
     *
     * @return string
     */
    public function getA33()
    {
        return $this->a33;
    }

    /**
     * Set a34
     *
     * @param string $a34
     *
     * @return RyR
     */
    public function setA34($a34)
    {
        $this->a34 = $a34;

        return $this;
    }

    /**
     * Get a34
     *
     * @return string
     */
    public function getA34()
    {
        return $this->a34;
    }

    /**
     * Set a35
     *
     * @param string $a35
     *
     * @return RyR
     */
    public function setA35($a35)
    {
        $this->a35 = $a35;

        return $this;
    }

    /**
     * Get a35
     *
     * @return string
     */
    public function getA35()
    {
        return $this->a35;
    }

    /**
     * Set a36
     *
     * @param string $a36
     *
     * @return RyR
     */
    public function setA36($a36)
    {
        $this->a36 = $a36;

        return $this;
    }

    /**
     * Get a36
     *
     * @return string
     */
    public function getA36()
    {
        return $this->a36;
    }

    /**
     * Set a37
     *
     * @param string $a37
     *
     * @return RyR
     */
    public function setA37($a37)
    {
        $this->a37 = $a37;

        return $this;
    }

    /**
     * Get a37
     *
     * @return string
     */
    public function getA37()
    {
        return $this->a37;
    }

    /**
     * Set a38
     *
     * @param string $a38
     *
     * @return RyR
     */
    public function setA38($a38)
    {
        $this->a38 = $a38;

        return $this;
    }

    /**
     * Get a38
     *
     * @return string
     */
    public function getA38()
    {
        return $this->a38;
    }

    /**
     * Set a39
     *
     * @param string $a39
     *
     * @return RyR
     */
    public function setA39($a39)
    {
        $this->a39 = $a39;

        return $this;
    }

    /**
     * Get a39
     *
     * @return string
     */
    public function getA39()
    {
        return $this->a39;
    }

    /**
     * Set a310
     *
     * @param string $a310
     *
     * @return RyR
     */
    public function setA310($a310)
    {
        $this->a310 = $a310;

        return $this;
    }

    /**
     * Get a310
     *
     * @return string
     */
    public function getA310()
    {
        return $this->a310;
    }

    /**
     * Set b11
     *
     * @param string $b11
     *
     * @return RyR
     */
    public function setB11($b11)
    {
        $this->b11 = $b11;

        return $this;
    }

    /**
     * Get b11
     *
     * @return string
     */
    public function getB11()
    {
        return $this->b11;
    }

    /**
     * Set b12
     *
     * @param string $b12
     *
     * @return RyR
     */
    public function setB12($b12)
    {
        $this->b12 = $b12;

        return $this;
    }

    /**
     * Get b12
     *
     * @return string
     */
    public function getB12()
    {
        return $this->b12;
    }

    /**
     * Set b13
     *
     * @param string $b13
     *
     * @return RyR
     */
    public function setB13($b13)
    {
        $this->b13 = $b13;

        return $this;
    }

    /**
     * Get b13
     *
     * @return string
     */
    public function getB13()
    {
        return $this->b13;
    }

    /**
     * Set b14
     *
     * @param string $b14
     *
     * @return RyR
     */
    public function setB14($b14)
    {
        $this->b14 = $b14;

        return $this;
    }

    /**
     * Get b14
     *
     * @return string
     */
    public function getB14()
    {
        return $this->b14;
    }

    /**
     * Set b15
     *
     * @param string $b15
     *
     * @return RyR
     */
    public function setB15($b15)
    {
        $this->b15 = $b15;

        return $this;
    }

    /**
     * Get b15
     *
     * @return string
     */
    public function getB15()
    {
        return $this->b15;
    }

    /**
     * Set b16
     *
     * @param string $b16
     *
     * @return RyR
     */
    public function setB16($b16)
    {
        $this->b16 = $b16;

        return $this;
    }

    /**
     * Get b16
     *
     * @return string
     */
    public function getB16()
    {
        return $this->b16;
    }

    /**
     * Set b17
     *
     * @param string $b17
     *
     * @return RyR
     */
    public function setB17($b17)
    {
        $this->b17 = $b17;

        return $this;
    }

    /**
     * Get b17
     *
     * @return string
     */
    public function getB17()
    {
        return $this->b17;
    }

    /**
     * Set b18
     *
     * @param string $b18
     *
     * @return RyR
     */
    public function setB18($b18)
    {
        $this->b18 = $b18;

        return $this;
    }

    /**
     * Get b18
     *
     * @return string
     */
    public function getB18()
    {
        return $this->b18;
    }

    /**
     * Set b19
     *
     * @param string $b19
     *
     * @return RyR
     */
    public function setB19($b19)
    {
        $this->b19 = $b19;

        return $this;
    }

    /**
     * Get b19
     *
     * @return string
     */
    public function getB19()
    {
        return $this->b19;
    }

    /**
     * Set b110
     *
     * @param string $b110
     *
     * @return RyR
     */
    public function setB110($b110)
    {
        $this->b110 = $b110;

        return $this;
    }

    /**
     * Get b110
     *
     * @return string
     */
    public function getB110()
    {
        return $this->b110;
    }
    
    /**
     * Set b21
     *
     * @param string $b21
     *
     * @return RyR
     */
    public function setB21($b21)
    {
        $this->b21 = $b21;

        return $this;
    }

    /**
     * Get b21
     *
     * @return string
     */
    public function getB21()
    {
        return $this->b21;
    }

    /**
     * Set b22
     *
     * @param string $b22
     *
     * @return RyR
     */
    public function setB22($b22)
    {
        $this->b22 = $b22;

        return $this;
    }

    /**
     * Get b22
     *
     * @return string
     */
    public function getB22()
    {
        return $this->b22;
    }

    /**
     * Set b23
     *
     * @param string $b23
     *
     * @return RyR
     */
    public function setB23($b23)
    {
        $this->b23 = $b23;

        return $this;
    }

    /**
     * Get b23
     *
     * @return string
     */
    public function getB23()
    {
        return $this->b23;
    }

    /**
     * Set b24
     *
     * @param string $b24
     *
     * @return RyR
     */
    public function setB24($b24)
    {
        $this->b24 = $b24;

        return $this;
    }

    /**
     * Get b24
     *
     * @return string
     */
    public function getB24()
    {
        return $this->b24;
    }

    /**
     * Set b25
     *
     * @param string $b25
     *
     * @return RyR
     */
    public function setB25($b25)
    {
        $this->b25 = $b25;

        return $this;
    }

    /**
     * Get b25
     *
     * @return string
     */
    public function getB25()
    {
        return $this->b25;
    }

    /**
     * Set b26
     *
     * @param string $b26
     *
     * @return RyR
     */
    public function setB26($b26)
    {
        $this->b26 = $b26;

        return $this;
    }

    /**
     * Get b26
     *
     * @return string
     */
    public function getB26()
    {
        return $this->b26;
    }

    /**
     * Set b27
     *
     * @param string $b27
     *
     * @return RyR
     */
    public function setB27($b27)
    {
        $this->b27 = $b27;

        return $this;
    }

    /**
     * Get b27
     *
     * @return string
     */
    public function getB27()
    {
        return $this->b27;
    }

    /**
     * Set b28
     *
     * @param string $b28
     *
     * @return RyR
     */
    public function setB28($b28)
    {
        $this->b28 = $b28;

        return $this;
    }

    /**
     * Get b28
     *
     * @return string
     */
    public function getB28()
    {
        return $this->b28;
    }

    /**
     * Set b29
     *
     * @param string $b29
     *
     * @return RyR
     */
    public function setB29($b29)
    {
        $this->b29 = $b29;

        return $this;
    }

    /**
     * Get b29
     *
     * @return string
     */
    public function getB29()
    {
        return $this->b29;
    }

    /**
     * Set b210
     *
     * @param string $b210
     *
     * @return RyR
     */
    public function setB210($b210)
    {
        $this->b210 = $b210;

        return $this;
    }

    /**
     * Get b210
     *
     * @return string
     */
    public function getB210()
    {
        return $this->b210;
    }
    
    /**
     * Set b31
     *
     * @param string $b31
     *
     * @return RyR
     */
    public function setB31($b31)
    {
        $this->b31 = $b31;

        return $this;
    }

    /**
     * Get b31
     *
     * @return string
     */
    public function getB31()
    {
        return $this->b31;
    }

    /**
     * Set b32
     *
     * @param string $b32
     *
     * @return RyR
     */
    public function setB32($b32)
    {
        $this->b32 = $b32;

        return $this;
    }

    /**
     * Get b32
     *
     * @return string
     */
    public function getB32()
    {
        return $this->b32;
    }

    /**
     * Set b33
     *
     * @param string $b33
     *
     * @return RyR
     */
    public function setB33($b33)
    {
        $this->b33 = $b33;

        return $this;
    }

    /**
     * Get b33
     *
     * @return string
     */
    public function getB33()
    {
        return $this->b33;
    }

    /**
     * Set b34
     *
     * @param string $b34
     *
     * @return RyR
     */
    public function setB34($b34)
    {
        $this->b34 = $b34;

        return $this;
    }

    /**
     * Get b34
     *
     * @return string
     */
    public function getB34()
    {
        return $this->b34;
    }

    /**
     * Set b35
     *
     * @param string $b35
     *
     * @return RyR
     */
    public function setB35($b35)
    {
        $this->b35 = $b35;

        return $this;
    }

    /**
     * Get b35
     *
     * @return string
     */
    public function getB35()
    {
        return $this->b35;
    }

    /**
     * Set b36
     *
     * @param string $b36
     *
     * @return RyR
     */
    public function setB36($b36)
    {
        $this->b36 = $b36;

        return $this;
    }

    /**
     * Get b36
     *
     * @return string
     */
    public function getB36()
    {
        return $this->b36;
    }

    /**
     * Set b37
     *
     * @param string $b37
     *
     * @return RyR
     */
    public function setB37($b37)
    {
        $this->b37 = $b37;

        return $this;
    }

    /**
     * Get b37
     *
     * @return string
     */
    public function getB37()
    {
        return $this->b37;
    }

    /**
     * Set b38
     *
     * @param string $b38
     *
     * @return RyR
     */
    public function setB38($b38)
    {
        $this->b38 = $b38;

        return $this;
    }

    /**
     * Get b38
     *
     * @return string
     */
    public function getB38()
    {
        return $this->b38;
    }

    /**
     * Set b39
     *
     * @param string $b39
     *
     * @return RyR
     */
    public function setB39($b39)
    {
        $this->b39 = $b39;

        return $this;
    }

    /**
     * Get b39
     *
     * @return string
     */
    public function getB39()
    {
        return $this->b39;
    }

    /**
     * Set b310
     *
     * @param string $b310
     *
     * @return RyR
     */
    public function setB310($b310)
    {
        $this->b310 = $b310;

        return $this;
    }

    /**
     * Get b310
     *
     * @return string
     */
    public function getB310()
    {
        return $this->b310;
    }

    /**
     * Set c11
     *
     * @param string $c11
     *
     * @return RyR
     */
    public function setC11($c11)
    {
        $this->c11 = $c11;

        return $this;
    }

    /**
     * Get c11
     *
     * @return string
     */
    public function getC11()
    {
        return $this->c11;
    }

    /**
     * Set c12
     *
     * @param string $c12
     *
     * @return RyR
     */
    public function setC12($c12)
    {
        $this->c12 = $c12;

        return $this;
    }

    /**
     * Get c12
     *
     * @return string
     */
    public function getC12()
    {
        return $this->c12;
    }

    /**
     * Set c13
     *
     * @param string $c13
     *
     * @return RyR
     */
    public function setC13($c13)
    {
        $this->c13 = $c13;

        return $this;
    }

    /**
     * Get c13
     *
     * @return string
     */
    public function getC13()
    {
        return $this->c13;
    }

    /**
     * Set c14
     *
     * @param string $c14
     *
     * @return RyR
     */
    public function setC14($c14)
    {
        $this->c14 = $c14;

        return $this;
    }

    /**
     * Get c14
     *
     * @return string
     */
    public function getC14()
    {
        return $this->c14;
    }

    /**
     * Set c15
     *
     * @param string $c15
     *
     * @return RyR
     */
    public function setC15($c15)
    {
        $this->c15 = $c15;

        return $this;
    }

    /**
     * Get c15
     *
     * @return string
     */
    public function getC15()
    {
        return $this->c15;
    }

    /**
     * Set c16
     *
     * @param string $c16
     *
     * @return RyR
     */
    public function setC16($c16)
    {
        $this->c16 = $c16;

        return $this;
    }

    /**
     * Get c16
     *
     * @return string
     */
    public function getC16()
    {
        return $this->c16;
    }

    /**
     * Set c17
     *
     * @param string $c17
     *
     * @return RyR
     */
    public function setC17($c17)
    {
        $this->c17 = $c17;

        return $this;
    }

    /**
     * Get c17
     *
     * @return string
     */
    public function getC17()
    {
        return $this->c17;
    }

    /**
     * Set c18
     *
     * @param string $c18
     *
     * @return RyR
     */
    public function setC18($c18)
    {
        $this->c18 = $c18;

        return $this;
    }

    /**
     * Get c18
     *
     * @return string
     */
    public function getC18()
    {
        return $this->c18;
    }

    /**
     * Set c19
     *
     * @param string $c19
     *
     * @return RyR
     */
    public function setC19($c19)
    {
        $this->c19 = $c19;

        return $this;
    }

    /**
     * Get c19
     *
     * @return string
     */
    public function getC19()
    {
        return $this->c19;
    }

    /**
     * Set c110
     *
     * @param string $c110
     *
     * @return RyR
     */
    public function setC110($c110)
    {
        $this->c110 = $c110;

        return $this;
    }

    /**
     * Get c110
     *
     * @return string
     */
    public function getC110()
    {
        return $this->c110;
    }
    
    /**
     * Set c21
     *
     * @param string $c21
     *
     * @return RyR
     */
    public function setC21($c21)
    {
        $this->c21 = $c21;

        return $this;
    }

    /**
     * Get c21
     *
     * @return string
     */
    public function getC21()
    {
        return $this->c21;
    }

    /**
     * Set c22
     *
     * @param string $c22
     *
     * @return RyR
     */
    public function setC22($c22)
    {
        $this->c22 = $c22;

        return $this;
    }

    /**
     * Get c22
     *
     * @return string
     */
    public function getC22()
    {
        return $this->c22;
    }

    /**
     * Set c23
     *
     * @param string $c23
     *
     * @return RyR
     */
    public function setC23($c23)
    {
        $this->c23 = $c23;

        return $this;
    }

    /**
     * Get c23
     *
     * @return string
     */
    public function getC23()
    {
        return $this->c23;
    }

    /**
     * Set c24
     *
     * @param string $c24
     *
     * @return RyR
     */
    public function setC24($c24)
    {
        $this->c24 = $c24;

        return $this;
    }

    /**
     * Get c24
     *
     * @return string
     */
    public function getC24()
    {
        return $this->c24;
    }

    /**
     * Set c25
     *
     * @param string $c25
     *
     * @return RyR
     */
    public function setC25($c25)
    {
        $this->c25 = $c25;

        return $this;
    }

    /**
     * Get c25
     *
     * @return string
     */
    public function getC25()
    {
        return $this->c25;
    }

    /**
     * Set c26
     *
     * @param string $c26
     *
     * @return RyR
     */
    public function setC26($c26)
    {
        $this->c26 = $c26;

        return $this;
    }

    /**
     * Get c26
     *
     * @return string
     */
    public function getC26()
    {
        return $this->c26;
    }

    /**
     * Set c27
     *
     * @param string $c27
     *
     * @return RyR
     */
    public function setC27($c27)
    {
        $this->c27 = $c27;

        return $this;
    }

    /**
     * Get c27
     *
     * @return string
     */
    public function getC27()
    {
        return $this->c27;
    }

    /**
     * Set c28
     *
     * @param string $c28
     *
     * @return RyR
     */
    public function setC28($c28)
    {
        $this->c28 = $c28;

        return $this;
    }

    /**
     * Get c28
     *
     * @return string
     */
    public function getC28()
    {
        return $this->c28;
    }

    /**
     * Set c29
     *
     * @param string $c29
     *
     * @return RyR
     */
    public function setC29($c29)
    {
        $this->c29 = $c29;

        return $this;
    }

    /**
     * Get c29
     *
     * @return string
     */
    public function getC29()
    {
        return $this->c29;
    }

    /**
     * Set c210
     *
     * @param string $c210
     *
     * @return RyR
     */
    public function setC210($c210)
    {
        $this->c210 = $c210;

        return $this;
    }

    /**
     * Get c210
     *
     * @return string
     */
    public function getC210()
    {
        return $this->c210;
    }
    
    /**
     * Set c31
     *
     * @param string $c31
     *
     * @return RyR
     */
    public function setC31($c31)
    {
        $this->c31 = $c31;

        return $this;
    }

    /**
     * Get c31
     *
     * @return string
     */
    public function getC31()
    {
        return $this->c31;
    }

    /**
     * Set c32
     *
     * @param string $c32
     *
     * @return RyR
     */
    public function setC32($c32)
    {
        $this->c32 = $c32;

        return $this;
    }

    /**
     * Get c32
     *
     * @return string
     */
    public function getC32()
    {
        return $this->c32;
    }

    /**
     * Set c33
     *
     * @param string $c33
     *
     * @return RyR
     */
    public function setC33($c33)
    {
        $this->c33 = $c33;

        return $this;
    }

    /**
     * Get c33
     *
     * @return string
     */
    public function getC33()
    {
        return $this->c33;
    }

    /**
     * Set c34
     *
     * @param string $c34
     *
     * @return RyR
     */
    public function setC34($c34)
    {
        $this->c34 = $c34;

        return $this;
    }

    /**
     * Get c34
     *
     * @return string
     */
    public function getC34()
    {
        return $this->c34;
    }

    /**
     * Set c35
     *
     * @param string $c35
     *
     * @return RyR
     */
    public function setC35($c35)
    {
        $this->c35 = $c35;

        return $this;
    }

    /**
     * Get c35
     *
     * @return string
     */
    public function getC35()
    {
        return $this->c35;
    }

    /**
     * Set c36
     *
     * @param string $c36
     *
     * @return RyR
     */
    public function setC36($c36)
    {
        $this->c36 = $c36;

        return $this;
    }

    /**
     * Get c36
     *
     * @return string
     */
    public function getC36()
    {
        return $this->c36;
    }

    /**
     * Set c37
     *
     * @param string $c37
     *
     * @return RyR
     */
    public function setC37($c37)
    {
        $this->c37 = $c37;

        return $this;
    }

    /**
     * Get c37
     *
     * @return string
     */
    public function getC37()
    {
        return $this->c37;
    }

    /**
     * Set c38
     *
     * @param string $c38
     *
     * @return RyR
     */
    public function setC38($c38)
    {
        $this->c38 = $c38;

        return $this;
    }

    /**
     * Get c38
     *
     * @return string
     */
    public function getC38()
    {
        return $this->c38;
    }

    /**
     * Set c39
     *
     * @param string $c39
     *
     * @return RyR
     */
    public function setC39($c39)
    {
        $this->c39 = $c39;

        return $this;
    }

    /**
     * Get c39
     *
     * @return string
     */
    public function getC39()
    {
        return $this->c39;
    }

    /**
     * Set c310
     *
     * @param string $c310
     *
     * @return RyR
     */
    public function setC310($c310)
    {
        $this->c310 = $c310;

        return $this;
    }

    /**
     * Get c310
     *
     * @return string
     */
    public function getC310()
    {
        return $this->c310;
    }

    /**
     * Set nameA
     *
     * @param string $nameA
     *
     * @return RyR
     */
    public function setNameA($nameA)
    {
        $this->nameA = $nameA;

        return $this;
    }

    /**
     * Get nameA
     *
     * @return string
     */
    public function getNameA()
    {
        return $this->nameA;
    }

    /**
     * Set nameB
     *
     * @param string $nameB
     *
     * @return RyR
     */
    public function setNameB($nameB)
    {
        $this->nameB = $nameB;

        return $this;
    }

    /**
     * Get nameB
     *
     * @return string
     */
    public function getNameB()
    {
        return $this->nameB;
    }

    /**
     * Set nameC
     *
     * @param string $nameC
     *
     * @return RyR
     */
    public function setNameC($nameC)
    {
        $this->nameC = $nameC;

        return $this;
    }

    /**
     * Get nameC
     *
     * @return string
     */
    public function getNameC()
    {
        return $this->nameC;
    }

    /**
     * Set rutaArchivo
     *
     * @param string $rutaArchivo
     *
     * @return RyR
     */
    public function setRutaArchivo($rutaArchivo)
    {
        $this->rutaArchivo = $rutaArchivo;

        return $this;
    }

    /**
     * Get rutaArchivo
     *
     * @return string
     */
    public function getRutaArchivo()
    {
        return $this->rutaArchivo;
    }

    /**
     * Set usuarioM
     *
     * @param string $usuarioM
     *
     * @return RyR
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
     * @return RyR
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
}

