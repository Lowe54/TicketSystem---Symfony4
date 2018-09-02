<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="app_tickethistory")
 * @ORM\Entity(repositoryClass="App\Repository\TicketHistoryRepository")
 */
class TicketHistory {
  public function __construct(){
    $this->replydate = new \DateTime();
  }
  /**
    *@ORM\Id
    *@ORM\Column(type="integer", name="id")
    *@ORM\GeneratedValue(strategy="AUTO")
    */
  private $id;
  /**
    *@ORM\Column(type="integer", name="ticketId")
    */
  private $ticketId;
  /**
    *@ORM\Column(type="integer", name="responseId")
    */
  private $responseId;
  /**
  * @ORM\Column(name="content", type="text")
  */
 private $description;
  /**
  * @ORM\Column(name="reply_type", type="string")
  */
 private $replytype;
  /**
   * @ORM\ManyToOne(targetEntity="User")
   * @ORM\JoinColumn(name="requester", referencedColumnName="id")
   */
  private $requester;

  /**
   * @ORM\Column(type="datetime")
   */
  private $replydate;

  //GETTERS
  public function getreply_type()
  {
    return $this->replytype;
  }
  public function getreplydate()
  {
    return $this->replydate;
  }
  public function getcontent(){
    return $this->description;
  }
  public function getRequester()
  {
      return $this->requester;
  }

  //Setters
  public function setreply_type($replytype)
  {
    $this->replytype = $replytype;
  }
  public function setcontent($content)
  {
    $this->description = $content;
  }
  public function setrequester($requester)
  {
    $this->requester = $requester;
  }
  public function setTicketID($id)
  {
    $this->ticketId = $id;
  }
  public function setresponseID($id)
  {
    $this->responseId = $id;
  }
  public function setreplydate($date)
  {
    $this->replydate = $date;
  }
}
