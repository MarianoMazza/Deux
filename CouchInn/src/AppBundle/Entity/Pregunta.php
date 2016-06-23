<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="pregunta")
 */
class Pregunta
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="pregunta")
     * @ORM\JoinColumn(name="deUsuario", referencedColumnName="id")
     */
    private $deUsuario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="misPreguntasParaResponde")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $aUsuario;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Publicacion", inversedBy="pregunta")
     * @ORM\JoinColumn(name="publicacion", referencedColumnName="id", onDelete="CASCADE")
     */
    private $publicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="pregunta", type="text")
     */
    private $pregunta;

    /**
     * @var string
     *
     * @ORM\Column(name="respuesta", type="text")
     */
    private $respuesta;

    /**
     * @ORM\Column(name="respondido", type="boolean")
     */
    private $respondido;




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
     * @return Pregunta
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
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
     * Set deUsuario
     *
     * @param integer $deUsuario

     */
    public function setDeUsuario($deUsuario)
    {
        $this->deUsuario = $deUsuario;


    }

    /**
     * Get deUsuario
     *
     * @return integer 
     */
    public function getDeUsuario()
    {
        return $this->deUsuario;
    }




    /**
    * Set aUsuario
    *
    * @param integer $aUsuario
     */
    public function setAUsuario($aUsuario)
    {
        $this->aUsuario = $aUsuario;


    }

    /**
     * Get aUsuario
     *
     * @return integer
     */
    public function getAUsuario()
    {
        return $this->aUsuario;
    }


    /**
     * Set publicacion
     *
     * @param integer $publicacion

     */
    public function setPublicacion($publicacion)
    {
        $this->publicacion = $publicacion;


    }

    /**
     * Get publicacion
     *
     * @return integer 
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * Set pregunta
     *
     * @param string $pregunta
     * @return Pregunta
     */
    public function setPregunta($pregunta)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return string 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }

    /**
     * Set respuesta
     *
     * @param string $respuesta

     */
    public function setRespuesta($respuesta)
    {
        $this->respuesta = $respuesta;

    }

    /**
     * Get respuesta
     *
     * @return string
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set respuesta
     *
     * @param boolean $respondido

     */
    public function setRespondido($respondido)
    {
        $this->respondido = $respondido;
    }

    /**
     * Get respondido
     *
     * @return boolean
     */
    public function getRespondido()
    {
        return $this->respondido;
    }
}
