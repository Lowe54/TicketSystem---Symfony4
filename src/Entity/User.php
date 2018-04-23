<?php
// src/Entity/User.php

/**
 * @Author: James Lowe
 */
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;


/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AdvancedUserInterface, \Serializable
{
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", length=60)
     */
    private $lastName;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
    /**
     *
     * @ORM\Column(name="is_agent", type="boolean")
     */
    private $isAgent;
    
    /**
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin;
    
    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="assignee")
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    private $assignedtickets;
    
    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Ticket", mappedBy="requester")
     * @ORM\JoinColumn(name="requestedticket_id", referencedColumnName="id")
     */
    private $requestedtickets;
    
    public function __construct()
    {
        $this->isActive = true;
         $this->assignedtickets = new ArrayCollection();
         $this->requestedtickets = new ArrayCollection();
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }
    public function getId()
    {
        return $this->id;
    }
     public function getRoles()
    {
        return array('ROLE_USER');
    }
    public function getEmail()
    {
        return $this->email;
    }
    
      public function getFirstName()
    {
        return $this->firstName;
    }
    
      public function getLastName()
    {
        return $this->lastName;
    }
    
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    public function getUsername() {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getIsAgent()
    {
        return $this->isAgent;
    }
    
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }
    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }
    
    public function isEnabled()
    {
        return $this->isActive;
    }
    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->firstName,
            $this->lastName,
            $this->isActive,
            $this->isAgent,
            $this->isAdmin
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->firstName,
            $this->lastName,
            $this->isActive,
            $this->isAgent,
            $this->isAdmin
           
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}


