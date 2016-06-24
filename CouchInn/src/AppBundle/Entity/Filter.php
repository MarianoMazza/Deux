<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:51
 */

namespace AppBundle\Entity;


use AppBundle\Controller\PublicacionController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pagos")
 */
class Filter
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="boolean")
     */
    private $usado;
    /**
     * @ORM\Column(type="date")
     */
    private $fechaDisponibleInicio;
    /**
     * @ORM\Column(type="date")
     */
    private $fechaDisponibleFin;
    /**
     * @ORM\Column(type="integer")
     */
    private $monto;
    /**
     * @ORM\Column(type="integer")
     */
    private $maxPersonas;
    /**
     * @ORM\Column(type="date")
     */
    private $vencimiento;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="pagos")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    /**
     * Set monto
     *
     * @param integer $monto
     */
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }
    public function setUsado($usado)
    {
        $this->usado = $usado;
    }
    /**
    *
     */
    public function getUsado()
    {
        return $this->usado;
    }
    /**
     * Set fechaDePublicacion
     *
     * @param \DateTime $fecha
     * @return PublicacionController
     */
    public function setfechaDisponibleInicio($fecha)
    {
        $this->fechaDisponibleInicio = $fecha;
    }
    /**
     * Get fechaDePublicacion
     *
     * @return \DateTime
     */
    public function getfechaDisponibleInicio()
    {
        return $this->fechaDisponibleInicio;
    }
    /**
     * Set fechaDePublicacion
     *
     * @param \DateTime $fecha
     * @return PublicacionController
     */
    public function setfechaDisponibleFin($fecha)
    {
        $this->fechaDisponibleFin = $fecha;
    }
    /**
     * Get fechaDePublicacion
     *
     * @return \DateTime
     */
    public function getfechaDisponibleFin()
    {
        return $this->fechaDisponibleFin;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getMaxPersonas()
    {
        return $this->maxPersonas;
    }

    /**
     * Set monto
     *
     * @param integer $monto
     */
    public function setMaxPersonas($maxPersonas)
    {
        $this->maxPersonas = $maxPersonas;
    }
    /**
     * Get monto
     *
     * @return integer 
     */
    public function getMonto()
    {
        return $this->monto;
    }
    /**
     * estaVencido
     *
     * @return boolean
     */
    public function estaVencido()
    {
        if($this->vencimiento<= new \DateTime('today')){
            return true;
        }
        else return false;
    }
    /**
     * Set vencimiento
     *
     * @param \DateTime $vencimiento
     */
    public function setVencimiento($vencimiento)
    {
        $this->vencimiento = $vencimiento;
    }

    /**
     * Get vencimiento
     *
     * @return \DateTime 
     */
    public function getVencimiento()
    {
        return $this->vencimiento;
    }

    /**
     * Get usuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set usuario
     *
     * @param integer
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
}
