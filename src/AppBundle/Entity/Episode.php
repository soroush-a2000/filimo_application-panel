<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Episode
 *
 * @ORM\Table(name="episode_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EpisodeRepository")
 */
class Episode
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
     *      max = 50,
     * )
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;


    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="duration", type="string", length=255,nullable=true)
     */
    private $duration;


    /**
     * @var string
     * @ORM\Column(name="playas", type="string", length=255,nullable=true)
     */
    private $playas;

    /**
     * @var string
     * @ORM\Column(name="downloadas", type="string", length=255,nullable=true)
     */
    private $downloadas;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="Season", inversedBy="episodes")
     * @ORM\JoinColumn(name="season_id", referencedColumnName="id")
     */
    private $season;

    /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="thumbnail_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $thumbnail;

    /**
     * @var int
     *
     * @ORM\Column(name="downloads", type="integer")
     */
    private $downloads;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;





    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $media;


    /**
     * @Assert\File(mimeTypes={"image/jpeg","image/png" },maxSize="40M")
     */
    private $file;

    private $sourceurl;

    private $sourcetype;

    private $sourcequality;

    /**
     * @Assert\File(mimeTypes={"video/mp4","video/quicktime","video/x-matroska","video/webm"})
     */
    private $sourcefile;

    /**
    * @ORM\OneToMany(targetEntity="Subtitle", mappedBy="episode",cascade={"persist", "remove"})
    */
    private $subtitles;

    /**
    * @ORM\OneToMany(targetEntity="Source", mappedBy="episode",cascade={"persist", "remove"})
    */
    private $sources;

   public function __construct()
    {
        $this->created= new \DateTime();
        $this->subtitles = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->views = 0 ;
        $this->downloads = 0 ;
    }

    /**
    * Get id
    * @return  
    */
    public function getId()
    {
        return $this->id;
    }
    /**
    * Get title
    * @return  
    */
    public function getTitle()
    {
        return $this->title;
    }

    /**
    * Set title
    * @return $this
    */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    /**
    * Get season
    * @return  
    */
    public function getSeason()
    {
        return $this->season;
    }
    
    /**
    * Set season
    * @return $this
    */
    public function setSeason($season)
    {
        $this->season = $season;
        return $this;
    }

    /**
    * Get position
    * @return  
    */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
    * Set position
    * @return $this
    */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
    * Get created
    * @return  
    */
    public function getCreated()
    {
        return $this->created;
    }
    
    /**
    * Set created
    * @return $this
    */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
    * Get thumbnail
    * @return  
    */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
    
    /**
    * Set thumbnail
    * @return $this
    */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
    * Get description
    * @return  
    */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
    * Set description
    * @return $this
    */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Album
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
    * Get sourceurl
    * @return  
    */
    public function getSourceurl()
    {
        return $this->sourceurl;
    }
    
    /**
    * Set sourceurl
    * @return $this
    */
    public function setSourceurl($sourceurl)
    {
        $this->sourceurl = $sourceurl;
        return $this;
    }

    /**
    * Get sourcetype
    * @return  
    */
    public function getSourcetype()
    {
        return $this->sourcetype;
    }
    
    /**
    * Set sourcetype
    * @return $this
    */
    public function setSourcetype($sourcetype)
    {
        $this->sourcetype = $sourcetype;
        return $this;
    }

    /**
     * Get sourcequality
     * @return
     */
    public function getSourceQuality()
    {
        return $this->sourcequality;
    }
    /**
     * Set sourcequality
     * @return $this
     */
    public function setSourceQuality($sourcequality)
    {
        $this->sourcequality = $sourcequality;
        return $this;
    }

    /**
    * Get sourcefile
    * @return  
    */
    public function getSourcefile()
    {
        return $this->sourcefile;
    }
    
    /**
    * Set sourcefile
    * @return $this
    */
    public function setSourcefile($sourcefile)
    {
        $this->sourcefile = $sourcefile;
        return $this;
    }


    /**
    * Get media
    * @return  
    */
    public function getMedia()
    {
        return $this->media;
    }
    
    /**
    * Set media
    * @return $this
    */
    public function setMedia($media)
    {
        $this->media = $media;
        return $this;
    }

    /**
     * Add sources
     *
     * @param Wallpaper $subtitles
     * @return Subtitle
     */
    public function addSubtitle(Subtitle $subtitle)
    {
        $this->subtitles[] = $subtitle;

        return $this;
    }

    /**
     * Remove subtitles
     *
     * @param Subtitle $subtitles
     */
    public function removeSubtitle(Subtitle $subtitle)
    {
        $this->subtitles->removeElement($subtitle);
    }

    /**
     * Get subtitles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubtitles()
    {
        return $this->subtitles;
    }
        /**
     * Get subtitles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function setSubtitles($subtitles)
    {
        return $this->subtitles =  $subtitles;
    }

/**__________________________

    /**
     * Add sources
     *
     * @param Wallpaper $sources
     * @return Source
     */
    public function addSource(Source $sources)
    {
        $this->sources[] = $sources;

        return $this;
    }

    /**
     * Remove sources
     *
     * @param Source $sources
     */
    public function removeSource(Source $sources)
    {
        $this->sources->removeElement($sources);
    }

    /**
     * Get sources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSources()
    {
        return $this->sources;
    }
        /**
     * Get sources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function setSources($sources)
    {
        return $this->sources =  $sources;
    }

    /**
    * Get views
    * @return  
    */
    public function getViews()
    {
        return $this->views;
    }
    
    /**
    * Set views
    * @return $this
    */
    public function setViews($views)
    {
        $this->views = $views;
        return $this;
    }

    /**
    * Get downloads
    * @return  
    */
    public function getDownloads()
    {
        return $this->downloads;
    }
    
    /**
    * Set downloads
    * @return $this
    */
    public function setDownloads($downloads)
    {
        $this->downloads = $downloads;
        return $this;
    }

        /**
    * Get playas
    * @return  
    */
    public function getPlayas()
    {
        return $this->playas;
    }
    
    /**
    * Set playas
    * @return $this
    */
    public function setPlayas($playas)
    {
        $this->playas = $playas;
        return $this;
    }

    /**
    * Get downloadas
    * @return  
    */
    public function getDownloadas()
    {
        return $this->downloadas;
    }
    
    /**
    * Set downloadas
    * @return $this
    */
    public function setDownloadas($downloadas)
    {
        $this->downloadas = $downloadas;
        return $this;
    }

    /**
    * Get duration
    * @return  
    */
    public function getDuration()
    {
        return $this->duration;
    }
    
    /**
    * Set duration
    * @return $this
    */
    public function setDuration($duration)
    {
        $this->duration = $duration;
        return $this;
    }
     /**
    * Get shares
    * @return  
    */
    public function getDownloadsnumber()
    {
        return $this->number_format_short($this->downloads);
    }  
         /**
    * Get shares
    * @return  
    */
    public function getViewsnumber()
    {
        return $this->number_format_short($this->views);
    }  
    /**
     * @param $n
     * @return string
     * Use to convert large positive numbers in to short form like 1K+, 100K+, 199K+, 1M+, 10M+, 1B+ etc
     */
    function number_format_short( $n ) {
        if ($n==0){
             return 0;
        }
        if ($n > 0 && $n < 1000) {
            // 1 - 999
            $n_format = floor($n);
            $suffix = '';
        } else if ($n >= 1000 && $n < 1000000) {
            // 1k-999k
            $n_format = floor($n / 1000);
            $suffix = 'K+';
        } else if ($n >= 1000000 && $n < 1000000000) {
            // 1m-999m
            $n_format = floor($n / 1000000);
            $suffix = 'M+';
        } else if ($n >= 1000000000 && $n < 1000000000000) {
            // 1b-999b
            $n_format = floor($n / 1000000000);
            $suffix = 'B+';
        } else if ($n >= 1000000000000) {
            // 1t+
            $n_format = floor($n / 1000000000000);
            $suffix = 'T+';
        }

        return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
    }
}
