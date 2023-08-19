<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Season
 *
 * @ORM\Table(name="season_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SeasonRepository")
 */
class Season
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
     * @ORM\Column(name="title", type="string", length=255))
     */
    private $title;


    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="Poster", inversedBy="seasons")
     * @ORM\JoinColumn(name="poster_id", referencedColumnName="id", nullable=true)
     */
    private $poster;

    /**
    * @ORM\OneToMany(targetEntity="Episode", mappedBy="season",cascade={"persist", "remove"})
    * @ORM\OrderBy({"position" = "asc"})
    */
    private $episodes;



    public function __construct()
    {
        $this->episodes = new ArrayCollection();
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
    * Get episodes
    * @return  
    */
    public function getEpisodes()
    {
        return $this->episodes;
    }
    
    /**
    * Set episodes
    * @return $this
    */
    public function setEpisodes($episodes)
    {
        $this->episodes = $episodes;
        return $this;
    }
}
