<?php
/**
 * //src/Entity/Ticket.php
 * Author: James Lowe
 * Version: 1.0.0
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="app_tickets")
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column (type="text")
     */
    private $description;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="assignedtickets")
     * @ORM\JoinColumn(name="assignee", referencedColumnName="id")
     */
    private $assignee;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="requestedtickets")
     * @ORM\JoinColumn(name="requester", referencedColumnName="id")
     */
    private $requester;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdOn;

    /**
     * @ORM\Column(type="datetime", nullable=TRUE)
     */
    private $updatedOn;

     /**
     * @ORM\Column(name="Status", type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="string")
     */
    private $priority;


    //GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAssignee()
    {
        return $this->assignee;
    }

    public function getRequester()
    {
        return $this->requester;
    }

    public function getcreated_on()
    {
        return $this->createdOn;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getupdated_on()
    {
        return $this->updatedOn;
    }
    public function getPriority()
    {
        return $this->priority;
    }
    public function setAssignee($assigneeid)
    {
        $this->assignee = $assigneeid;
    }
    public function setRequester($requesterid)
    {
        $this->requester = $requesterid;
    }
    public function setUpdatedDate($updatedate)
    {
        $this->updatedOn = $updatedate;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

}
