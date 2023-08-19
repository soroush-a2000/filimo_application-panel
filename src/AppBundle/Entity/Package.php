<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MediaBundle\Entity\Media;
/**
 * Country
 *
 * @ORM\Table(name="sub_pack_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PackageRepository")
 */
class Package
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
     *
     * @ORM\Column(name="title", type="string", length=255 )
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="days",  type="integer" )
     */
    private $days;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255 )
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="price_off", type="string", length=255 , nullable = true)
     */
    private $priceoff ;

    /**
     * @var string
     *
     * @ORM\Column(name="sku_key", type="string", length=255 , nullable = true)
     */
    private $skukey ;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


    public function __construct()
    {

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
     * @return Package
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
     * Get days
     * @return
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set days
     * @return $this
     */
    public function setDays($days)
    {
        $this->days = $days;
        return $this;
    }

    /**
     * Set skukey
     *
     * @param string $skukey
     * @return Package
     */
    public function setSkuKey($skukey)
    {
        $this->skukey = $skukey;

        return $this;
    }

    /**
     * Get $skukey
     *
     * @return string
     */
    public function getSkuKey()
    {
        return $this->skukey;
    }


    /**
     * Set price
     *
     * @param string $price
     * @return Package
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }


    /**
     * Set price
     *
     * @param string $price
     * @return Package
     */
    public function setPriceOff($priceoff)
    {
        $this->priceoff = $priceoff;

        return $this;
    }

    /**
     * Get priceoff
     *
     * @return string
     */
    public function getPriceOff()
    {
        return $this->priceoff;
    }


    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Package
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

}
