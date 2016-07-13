<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comision
 *
 * @ORM\Table(name="comisiones")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ComisionRepository")
 */
class Comision
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;

    /**
     * @var int
     *
     * @ORM\Column(name="publicacion", type="integer")
     */
    private $publicacion;

    /**
     * @var int
     *
     * @ORM\Column(name="porcentaje", type="integer")
     */
    private $porcentaje;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float")
     */
    private $monto;

    /**
     * @var float
     *
     * @ORM\Column(name="ganancia", type="float")
     */
    private $ganancia;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Comision
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
     * Set publicacion
     *
     * @param string $publicacion
     * @return Comision
     */
    public function setPublicacion($publicacion)
    {
        $this->publicacion = $publicacion;

        return $this;
    }

    /**
     * Get publicacion
     *
     * @return string 
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return Comision
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return integer 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }

    /**
     * Set monto
     *
     * @param float $monto
     * @return Comision
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto
     *
     * @return float 
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set ganancia
     *
     * @param float $ganancia
     * @return Comision
     */
    public function setGanancia($ganancia)
    {
        $this->ganancia = $ganancia;

        return $this;
    }

    /**
     * Get ganancia
     *
     * @return float 
     */
    public function getGanancia()
    {
        return $this->ganancia;
    }
}
