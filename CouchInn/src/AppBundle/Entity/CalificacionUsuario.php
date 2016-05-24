<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:51
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="calificacionesUsuario")
 */
class CalificacionUsuario
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     * @Assert\Choice({1,2,3,4,5,6,7,8,9,10})
     */
    private $calificacion;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="misCalificaciones")
     * @ORM\JoinColumn(name="deUsuario_id", referencedColumnName="id")
     */
    private $deUsuario;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="calificaciones")
     * @ORM\JoinColumn(name="paraUsuario_id", referencedColumnName="id")
     */
    private $paraUsuario;

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
     * Set calificacion
     *
     * @param integer $calificacion
     * @return CalificacionUsuarioController
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;

        return $this;
    }

    /**
     * Get calificacion
     *
     * @return integer 
     */
    public function getCalificacion()
    {
        return $this->calificacion;
    }

    /**
     * Set deUsuario
     *
     * @param \AppBundle\Entity\Usuario $deUsuario
     * @return CalificacionUsuarioController
     */
    public function setDeUsuario(\AppBundle\Entity\Usuario $deUsuario = null)
    {
        $this->deUsuario = $deUsuario;

        return $this;
    }

    /**
     * Get deUsuario
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getDeUsuario()
    {
        return $this->deUsuario;
    }

    /**
     * Set paraUsuario
     *
     * @param \AppBundle\Entity\Usuario $paraUsuario
     * @return CalificacionUsuarioController
     */
    public function setParaUsuario(\AppBundle\Entity\Usuario $paraUsuario = null)
    {
        $this->paraUsuario = $paraUsuario;

        return $this;
    }

    /**
     * Get paraUsuario
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getParaUsuario()
    {
        return $this->paraUsuario;
    }
}
