<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MediaBundle\Entity\Media;
/**
 * Source
 *
 * @ORM\Table(name="source_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SourceRepository")
 */
class Source
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     * @ORM\Column(name="quality", type="string", length=255, nullable=true)
     */
    private $quality;

     /**
     * @var string
     *
     * @ORM\Column(name="url", type="text", nullable=true)
     */
    private $url;

    /**
     * @Assert\File(mimeTypes={"video/mp4","video/quicktime","video/x-matroska","video/webm"})
     */
    private $file;

     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $media;


     /**
     * @ORM\ManyToOne(targetEntity="Poster", inversedBy="sources")
     * @ORM\JoinColumn(name="poster_id", referencedColumnName="id", nullable=true)
     */
    private $poster;


     /**
     * @ORM\ManyToOne(targetEntity="Episode", inversedBy="sources")
     * @ORM\JoinColumn(name="episode_id", referencedColumnName="id", nullable=true)
     */
    private $episode;

     /**
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="sources")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=true)
     */
    private $channel;

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
     * @param string $type
     * @return Source
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getTypetext()
    {
        $choices = array(
                        1 => "Youtube",
                        2 => "m3u8",
                        3 => "dash",
                        4 => "mp4",
                        5 => "file"
        );
        return $choices[$this->type];
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $quality
     * @return Source
     */
    public function setQuality($quality)
    {
        $this->quality = $quality;

        return $this;
    }

    /**
     * Get quality
     *
     * @return string
     */
    public function getQuality()
    {
        return $this->quality;
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
    * Get channel
    * @return  
    */
    public function getChannel()
    {
        return $this->channel;
    }
    
    /**
    * Set channel
    * @return $this
    */
    public function setChannel($channel)
    {
        $this->channel = $channel;
        return $this;
    }
    /**
    * Get url
    * @return  
    */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
    * Set url
    * @return $this
    */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
    /**
    * Get video
    * @return  
    */
    public function getYoutubeid()
    {
        $parts = parse_url($this->getUrl());
        if(isset($parts['query'])){
            parse_str($parts['query'], $qs);
            if(isset($qs['v'])){
                return $qs['v'];
            }else if(isset($qs['vi'])){
                return $qs['vi'];
            }
        }
        if(isset($parts['path'])){
            $path = explode('/', trim($parts['path'], '/'));
            return $path[count($path)-1];
        }
        return false;
    }
}
