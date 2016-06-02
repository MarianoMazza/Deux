<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 22/05/16
 * Time: 20:50
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity()
 * @ORM\Table(name="fotos")
 * @ORM\HasLifecycleCallbacks
 */


class Foto
{
    /**
     * Image path
     *
     * @var string
     *
     * @ORM\Column(type="text", length=255, nullable=false)
     */
    private $path;
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * Image foto
     *
     * @var File
     *
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "El tamaño máximo permitido es 5MB.",
     *     mimeTypesMessage = "Solo se permiten determinados tipos de imágen."
     * )
     */
    private $foto;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Publicacion", inversedBy="fotos")
     * @ORM\JoinColumn(name="publicacion_id", referencedColumnName="id")
     */
    private $publicacion;

    /**
     * Get id
     *
     * @return integer
     */
    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    public function getId()
    {
        return $this->id;
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
     * Set publicacion
     *
     * @param \AppBundle\Entity\Publicacion $publicacion
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

    // La propiedad ruta almacena la ruta relativa al archivo y se persiste en la base de datos.
    // El getAbsolutePath() es un método útil que devuelve la ruta absoluta al archivo,
    // mientras que getWebPath() es un conveniente método que devuelve la ruta web, la cual se utiliza en una plantilla para enlazar el archivo cargado.
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir() . '/' . $this->path;

    }
}
