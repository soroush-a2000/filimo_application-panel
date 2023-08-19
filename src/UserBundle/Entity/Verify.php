<?php
// src/AppBundle/Entity/User.php

namespace UserBundle\Entity;

use DateInterval;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
/**
 * Verify
 *
 * @ORM\Table(name="verify_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenreRepository")
 */
class Verify
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
    @ORM\Column(name="mobile", type="string", length=12)
    */
    protected $mobile;

    /**
     * @var int
     *
     * @ORM\Column(name="code", type="integer")
     */
    private $code;

    /**
     * @var bool
     *
     * @ORM\Column(name="outdated", type="boolean")
     */
    private $outdated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_at", type="datetime")
     */
    private $created;


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
    * Get mobile
    * @return  
    */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
    * Set mobile
    * @return $this
    */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Set code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     * @return
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set enabled
     *
     * @param boolean $outdated
     * @return Verify
     */
    public function setOutDated($outdated)
    {
        $this->outdated = $outdated;

        return $this;
    }

    /**
     * Get outdated
     *
     * @return boolean
     */
    public function getOutDated()
    {
        return $this->outdated;
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Verify
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return
     */
    public function getCreated()
    {
        return $this->created;
    }

}