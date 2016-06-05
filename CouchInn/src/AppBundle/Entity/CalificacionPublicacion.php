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
 * @ORM\Table(name="calificacionPublicacion")
 */
class CalificacionPublicacion
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="misCalificacionesAPublicaciones")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $deUsuario;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Publicacion", inversedBy="calificaciones")
     * @ORM\JoinColumn(name="publicacion_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $publicacion;

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
     */
    public function setCalificacion($calificacion)
    {
        $this->calificacion = $calificacion;
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
     */
    public function setDeUsuario(\AppBundle\Entity\Usuario $deUsuario = null)
    {
        $this->deUsuario = $deUsuario;
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
     * Set publicacion
     *
     * @param \AppBundle\Entity\Publicacion $publicacion
     */
    public function setPublicacion(\AppBundle\Entity\Publicacion $publicacion = null)
    {
        $this->publicacion = $publicacion;
    }

    /**
     * Get publicacion
     *
     * @return \AppBundle\Entity\Publicacion 
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }
}
