<?php

namespace Basso\VisualCalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnidMedida
 *
 * @ORM\Table(name="neosys.unidades_medidas")
 * @ORM\Entity(repositoryClass="Basso\VisualCalBundle\Repository\UnidMedidaRepository")
 */
class UnidMedida
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_unidmedida", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="unidadmedida", type="string", length=50)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="unid_mp", type="string", length=5)
     */
    private $unidMp;


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
     * @return UnidMedida
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
     * Set unidMp
     *
     * @param string $unidMp
     *
     * @return UnidMedida
     */
    public function setUnidMp($unidMp)
    {
        $this->unidMp = $unidMp;

        return $this;
    }

    /**
     * Get unidMp
     *
     * @return string
     */
    public function getUnidMp()
    {
        return $this->unidMp;
    }
}

