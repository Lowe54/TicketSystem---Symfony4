<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Ticket;
use Psr\Log\LoggerInterface;

class AgentController extends Controller{
    /**
     *@Route("/agent/dashboard", name="agentDashboard")
     */
    public function Agent_Dashboard()
    {
       $repository = $this->getDoctrine()->getRepository(User::class);
       $assignees = $repository->findAll();
        
        
        //TODO: Ticket List(s);
       $ticketrepository = $this->getDoctrine()->getRepository(Ticket::class);
       $Unassigned = $ticketrepository->getUnassignedTickets();
      dump($Unassigned);

        return $this->render('agent/dashboard.html.twig', array('assigneeList'=> $assignees, 'UTickets' => $Unassigned));
    }
    
    /**
     *@Route("/agent/fetchticket", name="fetchticket")
     */
    public function fetchTicket(Request $request, LoggerInterface $logger)
    {
        
        $tid = $request->request->get('id');
        $logger->info("Passed ID is".$tid);
        //Repositories
        $repository = $this->getDoctrine()->getRepository(User::class);
        $assignees = $repository->findBy(['isAgent' => 1]);
        $ticketrepository = $this->getDoctrine()->getRepository(Ticket::class);
        $ticket = $ticketrepository->findOneBy(array('id' => $tid));
        $response = $this->renderView('agent/ticketview.html.twig', array(
               'id' => $ticket->getId(),
               'title' => $ticket->getTitle(),
               'description' => $ticket->getDescription(),
               'status' => $ticket->getStatus(),
               'priority'=> $ticket->getPriority(),
               'assigneeList' => $assignees
               ));
       $res = new Response(json_encode($response));
       $res->headers->set('Content-Type', 'application/json');
       if($response == null)
       {
       $logger->error("RESPONSE IS EMPTY");
       }
       return $res;
    }
}

