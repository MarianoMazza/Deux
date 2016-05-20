<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\GroupSequenceProviderInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $nombreDeUsuario;
    /**
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\Column(type="integer")
     */
    private $edad;
    /**
     * @ORM\Column(type="date")
     */
    private $fechaDeNacimiento;
    /**
     * @ORM\Column(type="string")
     */
    private $rol;
    /**
     * @ORM\Column(type="string")
     */
    private $calle;
    /**
     * @ORM\Column(type="string")
     */
    private $pais;
    /**
     * @ORM\Column(type="string")
     */
    private $provinicia;
    /**
     * @ORM\Column(type="string")
     */
    private $localidad;


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
     * Set nombreDeUsuario
     *
     * @param string $nombreDeUsuario
     * @return User
     */
    public function setNombreDeUsuario($nombreDeUsuario)
    {
        $this->nombreDeUsuario = $nombreDeUsuario;

        return $this;
    }

    /**
     * Get nombreDeUsuario
     *
     * @return string 
     */
    public function getNombreDeUsuario()
    {
        return $this->nombreDeUsuario;
    }

    /**
     * Set contraseña
     *
     * @param string $contraseña
     * @return User
     */
    public function setContraseña($password)
    {
        $this->contraseña = $password;

        return $this;
    }

    /**
     * Get contraseña
     *
     * @return string 
     */
    public function getContraseña()
    {
        return $this->password;
    }

    /**
     * Set edad
     *
     * @param integer $edad
     * @return User
     */
    public function setEdad($edad)
    {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return integer 
     */
    public function getEdad()
    {
        return $this->edad;
    }

    /**
     * Set fechaDeNacimiento
     *
     * @param \DateTime $fechaDeNacimiento
     * @return User
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
     * Set rol
     *
     * @param string $rol
     * @return User
     */
    public function setRol($rol)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return string 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set calle
     *
     * @param string $calle
     * @return User
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
     * Set pais
     *
     * @param string $pais
     * @return User
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
     * Set provinicia
     *
     * @param string $provinicia
     * @return User
     */
    public function setProvinicia($provinicia)
    {
        $this->provinicia = $provinicia;

        return $this;
    }

    /**
     * Get provinicia
     *
     * @return string 
     */
    public function getProvinicia()
    {
        return $this->provinicia;
    }

    /**
     * Set localidad
     *
     * @param string $localidad
     * @return User
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
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
}
