<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:51
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pagos")
 */
class Pago
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $monto;
    /**
     * @ORM\Column(type="integer")
     */
    private $tarjeta;
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Set monto
     *
     * @param integer $monto
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getTarjeta()
    {
        return $this->tarjeta;
    }

    /**
     * Set monto
     *
     * @param integer $monto
     */
    public function setTarjeta($tarjeta)
    {
        $this->tarjeta = $tarjeta;
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
