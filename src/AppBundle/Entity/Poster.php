<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MediaBundle\Entity\Media;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Poster
 *
 * @ORM\Table(name="poster_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PosterRepository")
 */
class Poster
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
     *      min = 3
     * )
     * @ORM\Column(name="title",type="string", length=255)
     */
    private $title;

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
     * @var string
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    /**
     * @var string
     * @ORM\Column(name="tags", type="text"  ,nullable=true)
     */
    private $tags;

    /**
     * @var string
     * @ORM\Column(name="rating", type="float")
     */
    private $rating;

    /**
     * @var string
     * @ORM\Column(name="imdb",type="float",nullable=true)
     */
    private $imdb;

    /**
    * @ORM\OneToMany(targetEntity="Rate", mappedBy="poster",cascade={"persist", "remove"})
    * @ORM\OrderBy({"created" = "desc"})
    */
    private $ratings;

    /**
     * @var string
     * @ORM\Column(name="classification", type="string", length=255 ,nullable=true)
     */
    private $classification;

    /**
     * @var string
     * @ORM\Column(name="year", type="integer" ,nullable=true)
     */
    private $year;

    /**
     * @var string
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var int
     *
     * @ORM\Column(name="downloads", type="integer")
     */
    private $downloads;

    /**
     * @var int
     *
     * @ORM\Column(name="shares", type="integer")
     */
    private $shares;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;

    /**
     * 
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="cover_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $cover;

     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="posted_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poster;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


        /**
     * @ORM\ManyToMany(targetEntity="Genre")
     * @ORM\JoinTable(name="posters_genres",
     *      joinColumns={@ORM\JoinColumn(name="poster_id", referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id",onDelete="CASCADE")},
     *      )
     */
    private $genres;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     */
    private $country;

    /**
     * @Assert\File(mimeTypes={"image/jpeg","image/png" },maxSize="200M")
     */
    private $fileposter;

    /**
     * @Assert\File(mimeTypes={"image/jpeg","image/png" },maxSize="200M")
     */
    private $filecover;


    private $sourceurl;

    private $sourcequality;

    private $sourcetype;

    /**
     * @Assert\File(mimeTypes={"video/mp4","video/quicktime","video/x-matroska","video/webm"})
     */
    private $sourcefile;

    /**
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     * )
     * @Assert\Length(
     *      min = 3,
     * )

     */
    private $trailerurl;

    private $trailertype;

    /**
     * @Assert\File(mimeTypes={"video/mp4","video/quicktime","video/x-matroska","video/webm"})
     */
    private $trailerfile;

    /**
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="poster",cascade={"persist", "remove"})
    * @ORM\OrderBy({"created" = "desc"})
    */
    private $comments;

    /**
    * @ORM\OneToMany(targetEntity="Role", mappedBy="poster",cascade={"persist", "remove"})
    * @ORM\OrderBy({"position" = "asc"})
    */
    private $roles;


    /**
    * @ORM\OneToMany(targetEntity="Source", mappedBy="poster",cascade={"persist", "remove"})
    */
    private $sources;

    /**
    * @ORM\OneToMany(targetEntity="Season", mappedBy="poster",cascade={"persist", "remove"})
    * @ORM\OrderBy({"position" = "asc"})
    */
    private $seasons;

    /**
    * @ORM\OneToMany(targetEntity="Subtitle", mappedBy="poster",cascade={"persist", "remove"})
    */
    private $subtitles;

    /**
     * @var bool
     *
     * @ORM\Column(name="comment", type="boolean")
     */
    private $comment;


    /**
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="comments")
     * @ORM\JoinColumn(name="trailer_id", referencedColumnName="id", nullable=true)
     */
    private $trailer;

    public function __construct()
    {
        $this->downloads = 0 ;
        $this->shares = 0 ;
        $this->views = 0 ;
        $this->genres = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->subtitles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->seasons = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->created= new \DateTime();
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
    * Set id
    * @return $this
    */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Wallpaper
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set downloads
     *
     * @param integer $downloads
     * @return Wallpaper
     */
    public function setDownloads($downloads)
    {
        $this->downloads = $downloads;

        return $this;
    }

    /**
     * Get downloads
     *
     * @return integer 
     */
    public function getDownloads()
    {
        return $this->downloads;
    }

    /**
    * Get shares
    * @return  
    */
    public function getShares()
    {
        return $this->shares;
    }
    
    /**
    * Set shares
    * @return $this
    */
    public function setShares($shares)
    {
        $this->shares = $shares;
        return $this;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Wallpaper
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
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
    * Get cover
    * @return  
    */
    public function getCover()
    {
        return $this->cover;
    }
    
    /**
    * Set cover
    * @return $this
    */
    public function setCover($cover)
    {
        $this->cover = $cover;
        return $this;
    }
   
    /**
     * Add genres
     *
     * @param Wallpaper $genres
     * @return Genre
     */
    public function addGenre(Genre $genres)
    {
        $this->genres[] = $genres;

        return $this;
    }

    /**
     * Remove genres
     *
     * @param Genre $genres
     */
    public function removeGenre(Genre $genres)
    {
        $this->genres->removeElement($genres);
    }

    /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGenres()
    {
        return $this->genres;
    }
        /**
     * Get genres
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function setGenres($genres)
    {
        return $this->genres =  $genres;
    }

    /**
     * Get country
     * @return
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * Set country
     * @return $this
     */
    public function setCountry($country)
    {
        return $this->country =  $country;
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
    * Get filecover
    * @return  
    */
    public function getFilecover()
    {
        return $this->filecover;
    }
    
    /**
    * Set filecover
    * @return $this
    */
    public function setFilecover($filecover)
    {
        $this->filecover = $filecover;
        return $this;
    }


    /**
    * Get fileposter
    * @return  
    */
    public function getFileposter()
    {
        return $this->fileposter;
    }
    
    /**
    * Set fileposter
    * @return $this
    */
    public function setFileposter($fileposter)
    {
        $this->fileposter = $fileposter;
        return $this;
    }


    public function __toString()
    {
       return $this->title;
    
    }
    /**
    * Get comment
    * @return  
    */
    public function getComment()
    {
        return $this->comment;
    }
    
    /**
    * Set comment
    * @return $this
    */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

       /**
     * Add comments
     *
     * @param Wallpaper $comments
     * @return Genre
     */
    public function addComment(Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param Comment $comments
     */
    public function removeComment(Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

           /**
     * Add seasons
     *
     * @param Poster $seasons
     * @return Season
     */
    public function addSeason(Season $season)
    {
        $this->seasons[] = $season;

        return $this;
    }

    /**
     * Remove seasons
     *
     * @param Season $seasons
     */
    public function removeSeason(Season $season)
    {
        $this->seasons->removeElement($season);
    }

    /**
     * Get seasons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSeasons()
    {
        return $this->seasons;
    }


       /**
     * Add roles
     *
     * @param Wallpaper $roles
     * @return Role
     */
    public function addRole(Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param Role $roles
     */
    public function removeRole(Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles;
    }


    /**
    * Get tags
    * @return  
    */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
    * Set tags
    * @return $this
    */
    public function setTags($tags)
    {
        $this->tags = $tags;
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
    /**
    * Get type
    * @return  
    */
    public function getType()
    {
        return $this->type;
    }
    
    /**
    * Set type
    * @return $this
    */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
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
    * Get views
    * @return  
    */
    public function getDownloadscountnumber()
    {
        $count = 0;
        foreach ($this->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $count+=$episode->getDownloads();
            }
        }
        return $this->number_format_short($count);
    } 
      /**
    * Get views
    * @return  
    */
    public function getViewscountnumber()
    {
        $count = 0;
        foreach ($this->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $count+=$episode->getViews();
            }
        }
        return $this->number_format_short($count);
    }  

    /**
    * Get views
    * @return  
    */
    public function getViewsnumber()
    {
        return $this->number_format_short($this->views);
    }  
    
    /**
    * Get views
    * @return  
    */
    public function getDownloadsnumber()
    {
        return $this->number_format_short($this->downloads);
    } 
    
    /**
    * Get views
    * @return  
    */
    public function getSharesnumber()
    {
        return $this->number_format_short($this->shares);
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

    /**
    * Get rating
    * @return  
    */
    public function getRating()
    {
        return $this->rating;
    }
    
    /**
    * Set rating
    * @return $this
    */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
    * Get classification
    * @return  
    */
    public function getClassification()
    {
        return $this->classification;
    }
    
    /**
    * Set classification
    * @return $this
    */
    public function setClassification($classification)
    {
        $this->classification = $classification;
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
    * Get year
    * @return  
    */
    public function getYear()
    {
        return $this->year;
    }
    
    /**
    * Set year
    * @return $this
    */
    public function setYear($year)
    {
        $this->year = $year;
        return $this;
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
    * Get trailertype
    * @return  
    */
    public function getTrailertype()
    {
        return $this->trailertype;
    }
    
    /**
    * Set trailertype
    * @return $this
    */
    public function setTrailertype($trailertype)
    {
        $this->trailertype = $trailertype;
        return $this;
    }

        /**
    * Get trailerurl
    * @return  
    */
    public function getTrailerurl()
    {
        return $this->trailerurl;
    }
    
    /**
    * Set trailerurl
    * @return $this
    */
    public function setTrailerurl($trailerurl)
    {
        $this->trailerurl = $trailerurl;
        return $this;
    }

        /**
    * Get trailerfile
    * @return  
    */
    public function getTrailerfile()
    {
        return $this->trailerfile;
    }
    
    /**
    * Set trailerfile
    * @return $this
    */
    public function setTrailerfile($trailerfile)
    {
        $this->trailerfile = $trailerfile;
        return $this;
    }
    /**
    * Get trailer
    * @return  
    */
    public function getTrailer()
    {
        return $this->trailer;
    }
    
    /**
    * Set trailer
    * @return $this
    */
    public function setTrailer($trailer)
    {
        $this->trailer = $trailer;
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
    * Get imdb
    * @return  
    */
    public function getImdb()
    {
        return $this->imdb;
    }
    
    /**
    * Set imdb
    * @return $this
    */
    public function setImdb($imdb)
    {
        $this->imdb = $imdb;
        return $this;
    }
}
