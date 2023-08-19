<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use MediaBundle\Entity\Media;
/**
 * Settings
 *
 * @ORM\Table(name="settings_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SettingsRepository")
 */
class Settings
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
     * @ORM\Column(name="appname", type="string", length=255 , nullable = true)
     */
    private $appname;

    /**
     * @var string
     *
     * @ORM\Column(name="appdescription", type="text", nullable = true)
     */
    private $appdescription;

    /**
     * @var string
     *
     * @ORM\Column(name="download_link", type="text", nullable = true)
     */
    private $downloadlink ;

    /**
     * @var string
     *
     * @ORM\Column(name="privacypolicy", type="text", nullable = true)
     */
    private $privacypolicy;

    /**
     * @var string
     *
     * @ORM\Column(name="notif_key", type="string", length=255 , nullable = true)
     */
    private $notifkey;

    /**
     * @var string
     *
     * @ORM\Column(name="notif_app_id", type="string", length=255 , nullable = true)
     */
    private $notifappid;

    /**
     * @var string
     *
     * @ORM\Column(name="auto_slider", type="string", length=255 , nullable = true)
     */
    private $autoslider;


    /**
     * @var string
     *
     * @ORM\Column(name="time_slider", type="integer", length=255 , nullable = true)
     */
    private $timeslider;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_gateway", type="string", length=255 , nullable = true)
     */
    private $paymentgateway;

    /**
     * @var string
     *
     * @ORM\Column(name="merchant_id ", type="string", length=255 , nullable = true)
     */
    private $merchantid;

    /**
     * @var string
     *
     * @ORM\Column(name="pay_api", type="string", length=255 , nullable = true)
     */
    private $payapi;

    /**
     * @var string
     *
     * @ORM\Column(name="payment_description", type="text", length=255 , nullable = true)
     */
    private $paymentdescription;

    /**
     * @var string
     *
     * @ORM\Column(name="rewardedadmobid", type="string", length=255 , nullable = true)
     */
    private $rewardedadmobid;

    /**
     * @var string
     *
     * @ORM\Column(name="banneradmobid", type="string", length=255 , nullable = true)
     */
    private $banneradmobid;


    /**
     * @var string
     *
     * @ORM\Column(name="bannerfacebookid", type="string", length=255 , nullable = true)
     */
    private $bannerfacebookid;


    /**
     * @var string
     *
     * @ORM\Column(name="bannertype", type="string", length=255 , nullable = true)
     */
    private $bannertype;

    /**
     * @var string
     *
     * @ORM\Column(name="nativeadmobid", type="string", length=255 , nullable = true)
     */
    private $nativeadmobid;

    /**
     * @var string
     *
     * @ORM\Column(name="nativefacebookid", type="string", length=255 , nullable = true)
     */
    private $nativefacebookid;

    /**
     * @var string
     *
     * @ORM\Column(name="nativeitem",  type="integer",  length=255 , nullable = true)
     */
    private $nativeitem;


    /**
     * @var string
     *
     * @ORM\Column(name="nativetype", type="string", length=255 , nullable = true)
     */
    private $nativetype;

    /**
     * @var string
     *
     * @ORM\Column(name="interstitialadmobid", type="string", length=255 , nullable = true)
     */
    private $interstitialadmobid;

    /**
     * @var string
     *
     * @ORM\Column(name="interstitialfacebookid", type="string", length=255 , nullable = true)
     */
    private $interstitialfacebookid;


     /**
     * @var string
     *
     * @ORM\Column(name="interstitialtype", type="string", length=255 , nullable = true)
     */
    private $interstitialtype;

     /**
     * @var string
     *
     * @ORM\Column(name="interstitialclick", type="integer", length=255 , nullable = true)
     */
    private $interstitialclick;

    /**
     * @Assert\File(mimeTypes={"image/jpeg","image/png" },maxSize="40M")
     */
    private $file;
     /**
     * @ORM\ManyToOne(targetEntity="MediaBundle\Entity\Media")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $media;

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
     * Set appname
     *
     * @param string $appname
     * @return Settings
     */
    public function setAppname($appname)
    {
        $this->appname = $appname;

        return $this;
    }

    /**
     * Get appname
     *
     * @return string 
     */
    public function getAppname()
    {
        return $this->appname;
    }

    /**
     * Set appdescription
     *
     * @param string $appdescription
     * @return Settings
     */
    public function setAppdescription($appdescription)
    {
        $this->appdescription = $appdescription;

        return $this;
    }

    /**
     * Get appdescription
     *
     * @return string 
     */
    public function getAppdescription()
    {
        return $this->appdescription;
    }

    /**
     * Set downloadlink
     *
     * @param string downloadlink
     * @return Settings
     */
    public function setDownloadLink($downloadlink)
    {
        $this->downloadlink = $downloadlink;

        return $this;
    }

    /**
     * Get downloadlink
     *
     * @return string 
     */
    public function getDownloadLink()
    {
        return $this->downloadlink;
    }

    /**
     * Set privacypolicy
     *
     * @param string $privacypolicy
     * @return Settings
     */
    public function setPrivacypolicy($privacypolicy)
    {
        $this->privacypolicy = $privacypolicy;

        return $this;
    }

    /**
     * Get privacypolicy
     *
     * @return string 
     */
    public function getPrivacypolicy()
    {
        return $this->privacypolicy;
    }

    /**
     * Set notifkey
     *
     * @param string $notifkey
     * @return Settings
     */
    public function setNotifkey($notifkey)
    {
        $this->notifkey = $notifkey;

        return $this;
    }

    /**
     * Get notifkey
     *
     * @return string 
     */
    public function getNotifKey()
    {
        return $this->notifkey;
    }


    /**
     * Set notifappid
     *
     * @param string $notifappid
     * @return Settings
     */
    public function setNotifAppId($notifappid)
    {
        $this->notifappid = $notifappid;

        return $this;
    }

    /**
     * Get notifappid
     *
     * @return string
     */
    public function getNotifAppId()
    {
        return $this->notifappid;
    }


    /**
     * Get autoslider
     * @return
     */
    public function getAutoSlider()
    {
        return $this->autoslider;
    }

    /**
     * Set autoslider
     * @return $this
     */
    public function setAutoSlider($autoslider)
    {
        $this->autoslider = $autoslider;
        return $this;
    }

    /**
     * Get timeslider
     * @return
     */
    public function getTimeSlider()
    {
        return $this->timeslider;
    }

    /**
     * Set timeslider
     * @return $this
     */
    public function setTimeSlider($timeslider)
    {
        $this->timeslider = $timeslider;
        return $this;
    }



    /**
     * Get paymentgateway
     * @return
     */
    public function getPaymentGateway()
    {
        return $this->paymentgateway;
    }

    /**
     * Set paymentgateway
     * @return $this
     */
    public function setPaymentGateway($paymentgateway)
    {
        $this->paymentgateway = $paymentgateway;
        return $this;
    }

    /**
     * Get merchantid
     * @return
     */
    public function getMerchantId()
    {
        return $this->merchantid;
    }

    /**
     * Set merchantid
     * @return $this
     */
    public function setMerchantId($merchantid)
    {
        $this->merchantid = $merchantid;
        return $this;
    }

    /**
     * Get payapi
     * @return
     */
    public function getPayApi()
    {
        return $this->payapi;
    }

    /**
     * Set paymentdescription
     * @return $this
     */
    public function setPaymentDescription($paymentdescription)
    {
        $this->paymentdescription = $paymentdescription;
        return $this;
    }

    /**
     * Get paymentdescription
     * @return
     */
    public function getPaymentDescription()
    {
        return $this->paymentdescription;
    }

    /**
     * Set payapi
     * @return $this
     */
    public function setPayApi($payapi)
    {
        $this->payapi = $payapi;
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
     * Set media
     *
     * @param string $media
     * @return image
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
    * Get banneradmobid
    * @return  
    */
    public function getBanneradmobid()
    {
        return $this->banneradmobid;
    }
    
    /**
    * Set banneradmobid
    * @return $this
    */
    public function setBanneradmobid($banneradmobid)
    {
        $this->banneradmobid = $banneradmobid;
        return $this;
    }

    /**
    * Get bannerfacebookid
    * @return  
    */
    public function getBannerfacebookid()
    {
        return $this->bannerfacebookid;
    }
    
    /**
    * Set bannerfacebookid
    * @return $this
    */
    public function setBannerfacebookid($bannerfacebookid)
    {
        $this->bannerfacebookid = $bannerfacebookid;
        return $this;
    }

    /**
    * Get nativefacebookid
    * @return  
    */
    public function getNativefacebookid()
    {
        return $this->nativefacebookid;
    }
    
    /**
    * Set nativefacebookid
    * @return $this
    */
    public function setNativefacebookid($nativefacebookid)
    {
        $this->nativefacebookid = $nativefacebookid;
        return $this;
    }

    /**
    * Get nativeadmobid
    * @return  
    */
    public function getNativeadmobid()
    {
        return $this->nativeadmobid;
    }
    
    /**
    * Set nativeadmobid
    * @return $this
    */
    public function setNativeadmobid($nativeadmobid)
    {
        $this->nativeadmobid = $nativeadmobid;
        return $this;
    }

    /**
    * Get interstitialfacebookid
    * @return  
    */
    public function getInterstitialfacebookid()
    {
        return $this->interstitialfacebookid;
    }
    
    /**
    * Set interstitialfacebookid
    * @return $this
    */
    public function setInterstitialfacebookid($interstitialfacebookid)
    {
        $this->interstitialfacebookid = $interstitialfacebookid;
        return $this;
    }

    /**
    * Get interstitialadmobid
    * @return  
    */
    public function getInterstitialadmobid()
    {
        return $this->interstitialadmobid;
    }
    
    /**
    * Set interstitialadmobid
    * @return $this
    */
    public function setInterstitialadmobid($interstitialadmobid)
    {
        $this->interstitialadmobid = $interstitialadmobid;
        return $this;
    }

    /**
    * Get bannertype
    * @return  
    */
    public function getBannertype()
    {
        return $this->bannertype;
    }
    
    /**
    * Set bannertype
    * @return $this
    */
    public function setBannertype($bannertype)
    {
        $this->bannertype = $bannertype;
        return $this;
    }

    /**
    * Get interstitialtype
    * @return  
    */
    public function getInterstitialtype()
    {
        return $this->interstitialtype;
    }
    
    /**
    * Set interstitialtype
    * @return $this
    */
    public function setInterstitialtype($interstitialtype)
    {
        $this->interstitialtype = $interstitialtype;
        return $this;
    }

    /**
    * Get nativetype
    * @return  
    */
    public function getNativetype()
    {
        return $this->nativetype;
    }
    
    /**
    * Set nativetype
    * @return $this
    */
    public function setNativetype($nativetype)
    {
        $this->nativetype = $nativetype;
        return $this;
    }

    /**
    * Get interstitialclick
    * @return  
    */
    public function getInterstitialclick()
    {
        return $this->interstitialclick;
    }
    
    /**
    * Set interstitialclick
    * @return $this
    */
    public function setInterstitialclick($interstitialclick)
    {
        $this->interstitialclick = $interstitialclick;
        return $this;
    }

    /**
    * Get nativeitem
    * @return  
    */
    public function getNativeitem()
    {
        return $this->nativeitem;
    }
    
    /**
    * Set nativeitem
    * @return $this
    */
    public function setNativeitem($nativeitem)
    {
        $this->nativeitem = $nativeitem;
        return $this;
    }

    /**
    * Get rewardedadmobid
    * @return  
    */
    public function getRewardedadmobid()
    {
        return $this->rewardedadmobid;
    }
    
    /**
    * Set rewardedadmobid
    * @return $this
    */
    public function setRewardedadmobid($rewardedadmobid)
    {
        $this->rewardedadmobid = $rewardedadmobid;
        return $this;
    }
}
