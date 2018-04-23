<?php
// src/Repository/TicketRepository.php
namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ticket::class);
    }
    
    public function getUnassignedTickets(): array
    {
        
        return $this->createQueryBuilder('p')
        // p.category refers to the "category" property on product
        ->innerJoin('p.requester', 'c')
        // selects all the category data to avoid the query
        ->addSelect('c')
        ->where('p.assignee is NULL')
        ->getQuery()
        ->execute();
        
        
//        $sql = '
//       SELECT * FROM `app_tickets` INNER JOIN app_users ON app_tickets.requester = app_users.id 
//        ';
//        
//        $stmt = $conn->prepare($sql);

       
    }
}