<?php
// src/AppBundle/Entity/User.php

namespace UserBundle\Entity;

use DateInterval;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use MediaBundle\Entity\Media as Media;
use AppBundle\Entity\Comment as Comment;
use AppBundle\Entity\Rate as Rate;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_table")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(name="subscribe_days", type="string", length=255, nullable=true)
     */
    protected $subdays;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="purchase_date", type="datetime")
     */
    protected $purchasedate;

    /**
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @ORM\Column(name="reset_password", type="string", length=20, nullable=true)
     */
    protected $resetpassword;

    /**
     * @var bool
     *
     * @ORM\Column(name="reset_password_status", type="boolean")
     */
    private $resetpasswordstatus;

    /**
     * @ORM\Column(name="token", type="text", nullable=true)
     */
    protected $token;

    /**
     * @ORM\Column(name="purchase_token", type="text", nullable=true)
     */
    protected $purchasetoken;


    /**
     * @var int
     */
    private $remainindays;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Comment", mappedBy="user",cascade={"persist", "remove"})
     * @ORM\OrderBy({"created" = "desc"})
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rate", mappedBy="user",cascade={"persist", "remove"})
     * @ORM\OrderBy({"created" = "desc"})
     */
    private $ratings;

    /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private $media;


    public function __construct()
    {
        parent::__construct();
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
     * Get resetpassword
     * @return
     */

    public function getResetPassword()
    {
        return $this->resetpassword;
    }

    /**
     * Set resetpassword
     * @return $this
     */
    public function setResetPassword($resetpassword)
    {
        $this->resetpassword = $resetpassword;
        return $this;
    }

    /**
     * Get resetpasswordstatus
     *
     * @return boolean
     */
    public function getResetPasswordStatus()
    {
        return $this->resetpasswordstatus;
    }

    /**
     * Set resetpasswordstatus
     *
     * @param boolean $resetpasswordstatus
     * @return User
     */
    public function setResetPasswordsStatus($resetpasswordstatus)
    {
        $this->resetpasswordstatus = $resetpasswordstatus;

        return $this;
    }

    /**
     * Get name
     * @return
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * Get subdays
     * @return
     */
    public function getSubDays()
    {
        return $this->subdays;
    }

    /**
     * Set subdays
     * @return $this
     */
    public function setSubDays($subdays)
    {
        $this->subdays = $subdays;
        return $this;
    }

    /**
     * Set purchasedate
     *
     * @param \DateTime $purchasedate
     * @return User
     */
    public function setPurchaseDate($purchasedate)
    {
        $this->purchasedate = $purchasedate;

        return $this;
    }

    /**
     * Get purchasedate
     *
     * @return
     */
    public function getPurchaseDate()
    {
        return $this->purchasedate;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        $this->username = $email;
    }

    public function __toString()
    {
        return $this->getName();
    }


    /**
     * Get token
     * @return
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }


    /**
     * Get purchasetoken
     * @return
     */
    public function getPurchaseToken()
    {
        return $this->purchasetoken;
    }

    /**
     * Set purchasetoken
     * @return $this
     */
    public function setPurchaseToken($purchasetoken)
    {
        $this->purchasetoken = $purchasetoken;
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
    public function setMedia(Media $media)
    {
        $this->media = $media;
        return $this;
    }

    /**
     * Get remainindays
     * @return
     * @throws \Exception
     */
    public function getRemaininDays()
    {
        if ($this->getSubDays() != null) {
            $myDays = $this->getSubDays();
            $purchaseDate = $this->getPurchaseDate();
            $date_add = $purchaseDate->add(new DateInterval('P' . $myDays . 'D'));
            $ts1 = (new \DateTime('now'))->getTimestamp();
            $ts2 = strtotime($date_add->format('Y-m-d H:i:s'));
            $diff = $ts2 - $ts1;
            $days_left = round($diff / (60 * 60 * 24));
        } else {
            $days_left = 0;
        }
        if($days_left <=0){
            $days_left = 0;
        }
        return $remainindays = $days_left;
    }

    /**
     * Set remainindays
     * @return $this
     */
    public function setRemaininDays($remainindays)
    {
        $this->subdays = $remainindays;
        $this->purchasedate = (new \DateTime('now'));
        return $this;
    }

}