<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:50
 */

namespace AppBundle\Entity;


use AppBundle\Controller\PublicacionController;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="publicaciones")
 */
class Publicacion
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     *
     * @ORM\Column(type="blob")
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff", "image/jpg"},
     *     maxSizeMessage = "El tamaño máximo permitido es 5MB.",
     *     mimeTypesMessage = "Solo se permiten determinados tipos de imágen."
     * )
     */
    private $foto;
    /**
     * @ORM\Column(type="text", length=500)
     */
    private $descripcion;
    /**
     * @ORM\Column(type="date")
     */
    private $fechaDePublicacion;
    /**
     * @ORM\Column(type="float")
     */
    private $costo;
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
    private $maxPersonas;
    /**
     * @ORM\Column(type="string")
     * @Assert\Country()
     */
    private $pais;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $provincia;
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $localidad;
    /**
     * @ORM\Column(type="string", length=20)
     */
    private $calle;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="publicaciones")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TipoHospedaje", inversedBy="publicaciones")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     */
    private $tipo;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Foto", mappedBy="publicacion")
     */
    private $fotos;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CalificacionPublicacion", mappedBy="publicacion")
     */
    private $calificaciones;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comentario", mappedBy="publicacion")
     */
    private $comentarios;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fotos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->calificaciones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comentarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setFechaDePublicacion(new \DateTime('now'));
    }

    
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return PublicacionController
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
     * Set fechaDePublicacion
     *
     * @param \DateTime $fechaDePublicacion
     * @return PublicacionController
     */
    public function setFechaDePublicacion($fechaDePublicacion)
    {
        $this->fechaDePublicacion = $fechaDePublicacion;

        return $this;
    }

    /**
     * Get fechaDePublicacion
     *
     * @return \DateTime 
     */
    public function getFechaDePublicacion()
    {
        return $this->fechaDePublicacion;
    }

    /**
     * Set costo
     *
     * @param float $costo
     * @return PublicacionController
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return float 
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set maxPersonas
     *
     * @param integer $maxPersonas
     * @return PublicacionController
     */
    public function setMaxPersonas($maxPersonas)
    {
        $this->maxPersonas = $maxPersonas;

        return $this;
    }

    /**
     * Get maxPersonas
     *
     * @return integer 
     */
    public function getMaxPersonas()
    {
        return $this->maxPersonas;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return PublicacionController
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return PublicacionController
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return PublicacionController
     */
    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * Get localidad
     *
     * @return string 
     */
    public function getLocalidad()
    {
        return $this->localidad;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return PublicacionController
     */
    public function setCalle($calle)
    {
        $this->calle = $calle;

        return $this;
    }

    /**
     * Get calle
     *
     * @return string 
     */
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     * @return PublicacionController
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set tipo
     *
     * @param \AppBundle\Entity\TipoHospedaje $tipo
     * @return PublicacionController
     */
    public function setTipo(\AppBundle\Entity\TipoHospedaje $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }


    /**
     * Get tipo
     *
     * @return \AppBundle\Entity\Publicacion 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Add fotos
     *
     * @param \AppBundle\Entity\Foto $fotos
     * @return PublicacionController
     */
    public function addFoto(\AppBundle\Entity\Foto $fotos)
    {
        $this->fotos[] = $fotos;

        return $this;
    }

    /**
     * Remove fotos
     *
     * @param \AppBundle\Entity\Foto $fotos
     */
    public function removeFoto(\AppBundle\Entity\Foto $fotos)
    {
        $this->fotos->removeElement($fotos);
    }

    /**
     * Add calificaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $calificaciones
     * @return PublicacionController
     */
    public function addCalificacione(\AppBundle\Entity\CalificacionPublicacion $calificaciones)
    {
        $this->calificaciones[] = $calificaciones;

        return $this;
    }

    /**
     * Remove calificaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $calificaciones
     */
    public function removeCalificacione(\AppBundle\Entity\CalificacionPublicacion $calificaciones)
    {
        $this->calificaciones->removeElement($calificaciones);
    }

    /**
     * Add comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     * @return PublicacionController
     */
    public function addComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios[] = $comentarios;

        return $this;
    }

    /**
     * Remove comentarios
     *
     * @param \AppBundle\Entity\Comentario $comentarios
     */
    public function removeComentario(\AppBundle\Entity\Comentario $comentarios)
    {
        $this->comentarios->removeElement($comentarios);
    }

    /**
     * Get calificaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */

    public function getCalificaciones()
    {
        return $this->calificaciones;
    }

    /**
     * Get comentarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComentarios()
    {
        return $this->comentarios;
    }

    /**
     * Set foto
     *
     * @param $foto
     */
    public function setFoto(UploadedFile $foto = null)
    {
        $this->foto = $foto;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set fechaDisponibleInicio
     *
     * @param \DateTime $fechaDisponibleInicio
     * @return Publicacion
     */
    public function setFechaDisponibleInicio($fechaDisponibleInicio)
    {
        $this->fechaDisponibleInicio = $fechaDisponibleInicio;

        return $this;
    }

    /**
     * Get fechaDisponibleInicio
     *
     * @return \DateTime 
     */
    public function getFechaDisponibleInicio()
    {
        return $this->fechaDisponibleInicio;
    }

    /**
     * Set fechaDisponibleFin
     *
     * @param \DateTime $fechaDisponibleFin
     * @return Publicacion
     */
    public function setFechaDisponibleFin($fechaDisponibleFin)
    {
        $this->fechaDisponibleFin = $fechaDisponibleFin;

        return $this;
    }

    /**
     * Get fechaDisponibleFin
     *
     * @return \DateTime 
     */
    public function getFechaDisponibleFin()
    {
        return $this->fechaDisponibleFin;
    }

    /**
     * Get fotos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFotos()
    {
        return $this->fotos;
    }
}
