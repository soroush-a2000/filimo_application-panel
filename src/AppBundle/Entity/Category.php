<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MediaBundle\Entity\Media;
/**
 * Category
 *
 * @ORM\Table(name="category_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\ManyToMany(targetEntity="Channel"  ,mappedBy="categories")
     * @ORM\OrderBy({"created" = "desc"})
     */
    private $channels;




    public function __construct()
    {
        $this->channels = new ArrayCollection();
    }
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
     * Set title
     *
     * @param string $title
     * @return Category
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
     * Set position
     *
     * @param integer $position
     * @return Category
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }



        /**
     * Add image
     *
     * @param image $image
     * @return Categorie
     */
    public function addChannel(Channel $element)
    {
        $this->channels[] = $element;

        return $this;
    }

    /**
     * Remove channels
     *
     * @param channels $channels
     */
    public function removeChannel(Channel $element)
    {
        $this->channels->removeElement($element);
    }

    /**
     * Get channels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChannel()
    {
        return $this->channels;
    }
        public function __toString()
    {
        return $this->title;
    }
    public function getCategory()
    {
        return $this;
    }
}
