<?php
namespace App\Repository;

use App\Entity\TicketHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TicketHistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TicketHistory::class);
    }

    public function countHistory($id)
    {
      $conn =$this->getEntityManager()->getConnection();

      $sql = 'SELECT * FROM app_tickethistory th WHERE th.ticketID = :id';
      $stmt = $conn->prepare($sql);
      $stmt->execute(['id' => $id]);
      $c = $stmt->rowCount();
      
      return $c;
    }
}
?>
