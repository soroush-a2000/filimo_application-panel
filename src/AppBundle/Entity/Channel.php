<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MediaBundle\Entity\Media;
use UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Channel
 *
 * @ORM\Table(name="channel_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChannelRepository")
 */
class Channel
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
     * @ORM\Column(name="tags", type="text" ,nullable=true)
     */
    private $tags;

    /**
     * @var string
     * @ORM\Column(name="rating", type="float")
     */
    private $rating;


    /**
    * @ORM\OneToMany(targetEntity="Rate", mappedBy="channel",cascade={"persist", "remove"})
    * @ORM\OrderBy({"created" = "desc"})
    */
    private $ratings;

    /**
    * @var string
    * @ORM\Column(name="classification", type="string", length=255,nullable=true)
    */
    private $classification;


    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
     */
    private $country;

    /**
    * @var string
    * @Assert\Url
    * @ORM\Column(name="website", type="string", length=255,nullable=true)
    */
    private $website;

    /**
     * @var int
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;

    /**
     * @var int
     *
     * @ORM\Column(name="shares", type="integer")
     */
    private $shares;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;


     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $media;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="featured", type="boolean")
     */
    private $featured;

    /**
     * @ORM\ManyToMany(targetEntity="Category")
     * @ORM\JoinTable(name="channels_categories",
     *      joinColumns={@ORM\JoinColumn(name="channel_id", referencedColumnName="id",onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id",onDelete="CASCADE")},
     *      )
     */
    private $categories;




    /**
     * @Assert\File(mimeTypes={"image/jpeg","image/png" },maxSize="200M")
     */
    private $file;


    /**
     * @var string
     * @ORM\Column(name="playas", type="string", length=255,nullable=true)
     */
    private $playas;


    /**
    * @ORM\OneToMany(targetEntity="Comment", mappedBy="channel",cascade={"persist", "remove"})
    * @ORM\OrderBy({"created" = "desc"})
    */
    private $comments;

    /**
    * @ORM\OneToMany(targetEntity="Source", mappedBy="channel",cascade={"persist", "remove"})
    */
    private $sources;


    private $sourceurl;

    private $sourcetype;

    private $sourcequality;

    /**
     * @var bool
     *
     * @ORM\Column(name="comment", type="boolean")
     */
    private $comment;


    public function __construct()
    {
        $this->ratings = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->created= new \DateTime();
        $this->rating=0;
        $this->views=0;
        $this->shares=0;
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
    * Get featured
    * @return  
    */
    public function getFeatured()
    {
        return $this->featured;
    }
    
    /**
    * Set featured
    * @return $this
    */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
        return $this;
    }
    /**
     * Set media
     *
     * @param string $media
     * @return Wallpaper
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
     * Add categories
     *
     * @param Wallpaper $categories
     * @return Categorie
     */
    public function addCategory(Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param Category $categories
     */
    public function removeCategory(Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }
        /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function setCategories($categories)
    {
        return $this->categories =  $categories;
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
     * @return Categorie
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
    * Get sources
    * @return  
    */
    public function getSources()
    {
        return $this->sources;
    }
    
    /**
    * Set sources
    * @return $this
    */
    public function setSources($sources)
    {
        $this->sources = $sources;
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
    * Get website
    * @return  
    */
    public function getWebsite()
    {
        return $this->website;
    }
    
    /**
    * Set website
    * @return $this
    */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
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
    * Get ratings
    * @return  
    */
    public function getRatings()
    {
        return $this->ratings;
    }
    
    /**
    * Set ratings
    * @return $this
    */
    public function setRatings($ratings)
    {
        $this->ratings = $ratings;
        return $this;
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
    * Get sourceurl
    * @return  
    */
    public function getSourceurl()
    {
        return $this->sourceurl;
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
    * Set sourceurl
    * @return $this
    */
    public function setSourceurl($sourceurl)
    {
        $this->sourceurl = $sourceurl;
        return $this;
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
    * Get shares
    * @return  
    */
    public function getSharesnumber()
    {
        return $this->number_format_short($this->shares);
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
    * Set shares
    * @return $this
    */
    public function setShares($shares)
    {
        $this->shares = $shares;
        return $this;
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
}
