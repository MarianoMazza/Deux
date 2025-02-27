<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:50
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 */
class Usuario extends BaseUser implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="date")
     * @Assert\Date(
     *     message="La fecha ingresada es inválida"
     * )
     */
    private $fechaDeNacimiento;
    /**
     * @ORM\Column(type="string")
     * @Assert\Country(
     *     message="El país ingresado es inválido"
     * )
     */
    private $pais;
    /**
     * @ORM\Column(type="string")
     */
    private $provincia;
    /**
     * @ORM\Column(type="date",nullable=true)
     * @Assert\Date(
     *     message="La fecha ingresada es inválida"
     * )
     */
    private $fechaRegistro;
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $localidad;
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $calle;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Publicacion", mappedBy="usuario")
     */
    private $publicaciones;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CalificacionUsuario", mappedBy="paraUsuario")
     */
    private $calificaciones;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CalificacionUsuario", mappedBy="deUsuario")
     */
    private $misCalificacionesAUsuarios;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CalificacionPublicacion", mappedBy="deUsuario")
     */
    private $misCalificacionesAPublicaciones;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comentario", mappedBy="deUsuario")
     */
    private $misComentarios;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pago", mappedBy="usuario")
     */
    private $pagos;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Solicitud", mappedBy="usuario")
     */
    private $misSolicitudes;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pregunta", mappedBy="aUsuario")
     */
    private $misPreguntasParaResponder;


    public function __construct()
    {
        parent::__construct();
        $this->setFechaRegistro(new \DateTime('today'));
        $this->addRole('ROLE_USER');
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set fechaDeNacimiento
     *
     * @param \DateTime $fechaDeNacimiento
     * @return Usuario
     */
    public function setFechaDeNacimiento($fechaDeNacimiento)
    {
        $this->fechaDeNacimiento = $fechaDeNacimiento;

        return $this;
    }

    /**
     * Get fechaDeNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaDeNacimiento()
    {
        return $this->fechaDeNacimiento;
    }
    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return Usuario
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set pais
     *
     * @param string $pais
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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
     * @return Usuario
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

    public function isUser(\FOS\UserBundle\Model\UserInterface $user = null)
    {
        // TODO: Implement isUser() method.
    }

    /**
     * Add publicaciones
     *
     * @param \AppBundle\Entity\Publicacion $publicaciones
     * @return Usuario
     */
    public function addPublicacione(\AppBundle\Entity\Publicacion $publicaciones)
    {
        $this->publicaciones[] = $publicaciones;

        return $this;
    }

    /**
     * Remove publicaciones
     *
     * @param \AppBundle\Entity\Publicacion $publicaciones
     */
    public function removePublicacione(\AppBundle\Entity\Publicacion $publicaciones)
    {
        $this->publicaciones->removeElement($publicaciones);
    }

    /**
     * Get publicaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPublicaciones()
    {
        return $this->publicaciones;
    }
    
    
    /**
     * Add calificaciones
     *
     * @param \AppBundle\Entity\CalificacionUsuario $calificaciones
     * @return Usuario
     */
    public function addCalificacione(\AppBundle\Entity\CalificacionUsuario $calificaciones)
    {
        $this->calificaciones[] = $calificaciones;

        return $this;
    }

    /**
     * Remove calificaciones
     *
     * @param \AppBundle\Entity\CalificacionUsuario $calificaciones
     */
    public function removeCalificacione(\AppBundle\Entity\CalificacionUsuario $calificaciones)
    {
        $this->calificaciones->removeElement($calificaciones);
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
     * Add misCalificacionesAUsuarios
     *
     * @param \AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios
     * @return Usuario
     */
    public function addMisCalificacionesAUsuario(\AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios)
    {
        $this->misCalificacionesAUsuarios[] = $misCalificacionesAUsuarios;

        return $this;
    }

    /**
     * Remove misCalificacionesAUsuarios
     *
     * @param \AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios
     */
    public function removeMisCalificacionesAUsuario(\AppBundle\Entity\CalificacionUsuario $misCalificacionesAUsuarios)
    {
        $this->misCalificacionesAUsuarios->removeElement($misCalificacionesAUsuarios);
    }

    /**
     * Get misCalificacionesAUsuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisCalificacionesAUsuarios()
    {
        return $this->misCalificacionesAUsuarios;
    }

    /**
     * Add misCalificacionesAPublicaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones
     * @return Usuario
     */
    public function addMisCalificacionesAPublicacione(\AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones)
    {
        $this->misCalificacionesAPublicaciones[] = $misCalificacionesAPublicaciones;

        return $this;
    }

    /**
     * Remove misCalificacionesAPublicaciones
     *
     * @param \AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones
     */
    public function removeMisCalificacionesAPublicacione(\AppBundle\Entity\CalificacionPublicacion $misCalificacionesAPublicaciones)
    {
        $this->misCalificacionesAPublicaciones->removeElement($misCalificacionesAPublicaciones);
    }

    /**
     * Get misCalificacionesAPublicaciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisCalificacionesAPublicaciones()
    {
        return $this->misCalificacionesAPublicaciones;
    }

    /**
     * Add misComentarios
     *
     * @param \AppBundle\Entity\Comentario $misComentarios
     * @return Usuario
     */
    public function addMisComentario(\AppBundle\Entity\Comentario $misComentarios)
    {
        $this->misComentarios[] = $misComentarios;

        return $this;
    }

    /**
     * Remove misComentarios
     *
     * @param \AppBundle\Entity\Comentario $misComentarios
     */
    public function removeMisComentario(\AppBundle\Entity\Comentario $misComentarios)
    {
        $this->misComentarios->removeElement($misComentarios);
    }

    /**
     * Get misComentarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisComentarios()
    {
        return $this->misComentarios;
    }
    /**
     * return boolean
     */
    public function esPremium()
    {
        if (!$this->getPagos()->isEmpty()) {
            if($this->getPagos()->last()->estaVencido()){
                return false;
            }
            else return true;
        }
        return false;
    }
    /**
     * Add pagos
     *
     * @param \AppBundle\Entity\Pago $pagos
     * @return Usuario
     */
    public function addPago(\AppBundle\Entity\Pago $pagos)
    {
        $this->pagos[] = $pagos;

        return $this;
    }

    /**
     * Remove pagos
     *
     * @param \AppBundle\Entity\Pago $pagos
     */
    public function removePago(\AppBundle\Entity\Pago $pagos)
    {
        $this->pagos->removeElement($pagos);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    /**
     * Set misPreguntasParaResponder
     *
     * @param string $misPreguntasParaResponder
     */
    public function setMisPreguntasParaResponder($misPreguntasParaResponder)
    {
        $this->misPreguntasParaResponder = $misPreguntasParaResponder;

    }

    /**
     * Get misPreguntasParaResponder
     *
     * @return string
     */
    public function getMisPreguntasParaResponder()
    {
        return $this->misPreguntasParaResponder;
    }

    /**
     * Add misSolicitudes
     *
     * @param \AppBundle\Entity\Solicitud $misSolicitudes
     * @return Usuario
     */
    public function addMisSolicitude(\AppBundle\Entity\Solicitud $misSolicitudes)
    {
        $this->misSolicitudes[] = $misSolicitudes;

        return $this;
    }

    /**
     * Remove misSolicitudes
     *
     * @param \AppBundle\Entity\Solicitud $misSolicitudes
     */
    public function removeMisSolicitude(\AppBundle\Entity\Solicitud $misSolicitudes)
    {
        $this->misSolicitudes->removeElement($misSolicitudes);
    }

    /**
     * Get misSolicitudes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMisSolicitudes()
    {
        return $this->misSolicitudes;
    }

    /**
     * Add misPreguntasParaResponder
     *
     * @param \AppBundle\Entity\Pregunta $misPreguntasParaResponder
     * @return Usuario
     */
    public function addMisPreguntasParaResponder(\AppBundle\Entity\Pregunta $misPreguntasParaResponder)
    {
        $this->misPreguntasParaResponder[] = $misPreguntasParaResponder;

        return $this;
    }

    /**
     * Remove misPreguntasParaResponder
     *
     * @param \AppBundle\Entity\Pregunta $misPreguntasParaResponder
     */
    public function removeMisPreguntasParaResponder(\AppBundle\Entity\Pregunta $misPreguntasParaResponder)
    {
        $this->misPreguntasParaResponder->removeElement($misPreguntasParaResponder);
    }
}
