<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:50
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="comentarios")
 */
class Comentario
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="date")
     */
    private $fecha;
    /**
     * @ORM\Column(type="text", length=500)
     */
    private $comentario;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="misComentarios")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $deUsuario;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Publicacion", inversedBy="comentarios")
     * @ORM\JoinColumn(name="publicacion_id", referencedColumnName="id")
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
     * Set fecha
     *
     * @param \DateTime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    public function __construct()
    {
        $this->fecha = new \DateTime('now');
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
     * Set comentario
     *
     * @param string $comentario
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
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
     * @param string
     */
    public function setPublicacion($publicacion)
    {
        $this->publicacion = $publicacion;
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
}
