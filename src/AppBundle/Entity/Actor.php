<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MediaBundle\Entity\Media;
/**
 * Actor
 *
 * @ORM\Table(name="actor_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActorRepository")
 */
class Actor
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
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 25,
     * )
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="born", type="string", length=255)
     */
    private $born;

    /**
     * @var string
     * @ORM\Column(name="height", type="string", length=255)
     */
    private $height;

     /**
     * @var string
     * @ORM\Column(name="bio", type="text")
     */
    private $bio;

    /**
     * @Assert\File(mimeTypes={"image/jpeg","image/png" },maxSize="40M")
     */
    private $file;

     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $media;


    /**
    * @ORM\OneToMany(targetEntity="Role", mappedBy="actor",cascade={"persist", "remove"})
    * @ORM\OrderBy({"position" = "desc"})
    */
    private $roles;


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
     * Set name
     *
     * @param string $name
     * @return Actor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getActor()
    {
        return $this;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    /**
     * Set media
     *
     * @param string $media
     * @return image
     */
    public function setMedia(Media $media)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return string 
     */
    public function getMedia()
    {
        return $this->media;
    }
    /**
    * Get height
    * @return  
    */
    public function getHeight()
    {
        return $this->height;
    }
    
    /**
    * Set height
    * @return $this
    */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }
    /**
    * Get born
    * @return  
    */
    public function getBorn()
    {
        return $this->born;
    }
    
    /**
    * Set born
    * @return $this
    */
    public function setBorn($born)
    {
        $this->born = $born;
        return $this;
    }

    /**
    * Get bio
    * @return  
    */
    public function getBio()
    {
        return $this->bio;
    }
    
    /**
    * Set bio
    * @return $this
    */
    public function setBio($bio)
    {
        $this->bio = $bio;
        return $this;
    }

}
