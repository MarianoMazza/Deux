<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Porcentaje
 *
 * @ORM\Table(name="porcentaje")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PorcentajeRepository")
 */
class Porcentaje
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
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Debes ser al menos {{ limit }}cm de alto para entrar",
     *      maxMessage = "No puedes ser más alto que {{ limit }}cm para entrar"
     * )
     * @var int
     * @ORM\Column(name="porcentaje", type="integer")
     */
    private $porcentaje;


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
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return Porcentaje
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
}
