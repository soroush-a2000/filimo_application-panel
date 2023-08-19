<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;
/**
 * Comment
 *
 * @ORM\Table(name="comment_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;


    /**
     * @ORM\ManyToOne(targetEntity="Poster", inversedBy="comments")
     * @ORM\JoinColumn(name="poster_id", referencedColumnName="id", nullable=true)
     */
    private $poster;


    /**
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="comments")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", nullable=true)
     */
    private $channel;


    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;
    public function __construct()
    {
        $this->created= new \DateTime();

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
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    public function getContentclear()
    {
        return base64_decode($this->content);
    }
    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Comment
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
     * @return Comment
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }
    /**
    * Get user
    * @return  
    */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
    * Set user
    * @return $this
    */
    public function setUser(User $user)
    {
        $this->user = $user;
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
  
}
