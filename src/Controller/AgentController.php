<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Ticket;
use Psr\Log\LoggerInterface;

class AgentController extends Controller{
    /**
     *@Route("/agent/dashboard", name="agentDashboard")
     */
    public function Agent_Dashboard(LoggerInterface $logger)
    {
       $repository = $this->getDoctrine()->getRepository(User::class);
        //ToDO: Assignee List
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
        $ticketrepository = $this->getDoctrine()->getRepository(Ticket::class);
        $ticket = $ticketrepository->findOneBy(array('id' => $tid));
//        TODO: Covert this JSON Array to a updateable form/twig file
//        
//        
//        $arrData = ['output' => ''
//            . '<span class="ticketDetails">'
//            . ' <h2 class="idbox">'.$ticket->getid().'</h2>'
//           . ' <br/>'
//            . ' <h2>'.$ticket->getTitle().'</h2>'
//            . ' <p>'.$ticket->getDescription().'</p>'
//            . '</span>'
//           . '<span class="ticket-rbar">
//                <table>
//                <tr>
//               <td>Status</td>
//               <td>'.$ticket->getStatus().'</td>
//                </tr>
//                <tr>
//               <td>'.$ticket->getPriority().'</td>
//                </tr>
//             </span>'  
//           ];
        
       
       $response = $this->renderView('agent/ticketview.html.twig', array('id' => $ticket->getId(),'title' => $ticket->getTitle(),
               'description' => $ticket->getDescription()
               
               
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

