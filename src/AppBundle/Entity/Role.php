<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Role
 *
 * @ORM\Table(name="role_table")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 */
class Role
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
     * @ORM\Column(name="role", type="string", length=255))
     */
    private $role;


    /**
     * @var int
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="Poster", inversedBy="roles")
     * @ORM\JoinColumn(name="poster_id", referencedColumnName="id", nullable=true)
     */
    private $poster;

    /**
     * @ORM\ManyToOne(targetEntity="Actor", inversedBy="roles")
     * @ORM\JoinColumn(name="actor_id", referencedColumnName="id", nullable=true)
     */
    private $actor;

    /**
    * Get id
    * @return  
    */
    public function getId()
    {
        return $this->id;
    }
    /**
    * Get role
    * @return  
    */
    public function getRole()
    {
        return $this->role;
    }

    /**
    * Set role
    * @return $this
    */
    public function setRole($role)
    {
        $this->role = $role;
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
    * Get actor
    * @return  
    */
    public function getActor()
    {
        return $this->actor;
    }
    
    /**
    * Set actor
    * @return $this
    */
    public function setActor($actor)
    {
        $this->actor = $actor;
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
}
