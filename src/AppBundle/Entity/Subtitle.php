<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MediaBundle\Entity\Media;
/**
 * Subtitle
 *
 * @ORM\Table(name="subtitle_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubtitleRepository")
 */
class Subtitle
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
     * @Assert\File(mimeTypes={"text/plain"})
     */
    private $file;

     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $media;


     /**
     * @ORM\ManyToOne(targetEntity="Poster", inversedBy="subtitles")
     * @ORM\JoinColumn(name="poster_id", referencedColumnName="id", nullable=true)
     */
    private $poster;


     /**
     * @ORM\ManyToOne(targetEntity="Episode", inversedBy="subtitles")
     * @ORM\JoinColumn(name="episode_id", referencedColumnName="id", nullable=true)
     */
    private $episode;


     /**
     * @ORM\ManyToOne(targetEntity="Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id" , nullable=false)
     */
    private $language;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->name;
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
    public function setMedia($media)
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
    * Get poster
    * @return  
    */
    public function getPoster()
    {
        return $this->poster;
    }
    
    /**
    * Set poster
    * @return $this
    */
    public function setPoster($poster)
    {
        $this->poster = $poster;
        return $this;
    }

    /**
    * Get episode
    * @return  
    */
    public function getEpisode()
    {
        return $this->episode;
    }
    
    /**
    * Set episode
    * @return $this
    */
    public function setEpisode($episode)
    {
        $this->episode = $episode;
        return $this;
    }
    /**
    * Get language
    * @return  
    */
    public function getLanguage()
    {
        return $this->language;
    }
    
    /**
    * Set language
    * @return $this
    */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }
}
