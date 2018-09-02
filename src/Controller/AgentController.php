<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Ticket;
use App\Entity\TicketHistory;
use Psr\Log\LoggerInterface;

class AgentController extends Controller{
    /**
     *@Route("/agent/dashboard", name="agentDashboard")
     */
    public function Agent_Dashboard()
    {
        $ticketrepository = $this->getDoctrine()->getRepository(Ticket::class);
//      $Assigned = $ticketrepository->getAssignedTickets($id);
        $Unassigned = $ticketrepository->getUnassignedTickets();


        return $this->render('agent/dashboard.html.twig', array('UTickets' => $Unassigned));
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

        $assignees = $repository->findBy(['isAgent' => 1, 'isActive' => 1]);
        $requesters = $repository->findBy(['isActive' => 1]);

        $ticketrepository = $this->getDoctrine()->getRepository(Ticket::class);
        $history = $this->getDoctrine()->getRepository(TicketHistory::class);
        $ticket = $ticketrepository->findOneBy(array('id' => $tid));
        $tHist = $history->findBy(array('ticketId' => $tid));
        $response = $this->renderView('agent/ticketview.html.twig', array(
               'id' => $ticket->getId(),
               'title' => $ticket->getTitle(),
               'status' => $ticket->getStatus(),
               'priority'=> $ticket->getPriority(),
               'requesterId' => $ticket->getRequester(),
               'assigneeId' => $ticket->getAssignee(),
               'requester' => $requesters,
               'assigneeList' => $assignees,
               'messagehistory' => $tHist
               ));
       $res = new Response(json_encode($response));
       $res->headers->set('Content-Type', 'application/json');
       if($response == null)
       {
       $logger->error("RESPONSE IS EMPTY");
       }
       return $res;
    }


    /**
     *@Route("/agent/updateticket", name="updateticket")
     */
    public function updateTicket(Request $request, LoggerInterface $logger)
    {
      // TODO: Figure out a way to store htmlentities
       $tid = $request->request->get('id');
       $title = $request->request->get('title');
       $assignee = $request->request->get('assignee');
       $requester = $request->request->get('requester');
       $status = $request->request->get('status');
       $priority = $request->request->get('priority');
       $entityManager = $this->getDoctrine()->getManager();
       $ticket = $entityManager->getRepository(Ticket::class)->findOneBy(array('id' => $tid));
       $newassignee = $entityManager->getRepository(User::class)->findOneBy(array('id' => $assignee));
       $newreq = $entityManager->getRepository(User::class)->findOneBy(array('id' => $requester));

    if (!$ticket) {
        throw $this->createNotFoundException(
            'No ticket found for id '.$tid
        );
    }
      $reply = $request->request->get('reply');
      $replytype = $request->request->get('replytype');
      $uid = $request->request->get('userId');
      $user = $entityManager->getRepository(User::class)->findOneBy(array('id' => $uid));
      //$logger->log('info', $uid);
      //TicketHistory
      $history = $this->getDoctrine()->getRepository(TicketHistory::class);
      $thr = new TicketHistory();
      $th = $history->countHistory($tid);
      $logger->log('info', $th);
      //$logger->log('info', $th);
      $th = $th + 1;
      $thr->setTicketID($tid);
      $thr->setresponseID($th);
      $thr->setContent($reply);
      $thr->setreply_type(strtoupper($replytype));
      $thr->setRequester($user);

      $ticket->setTitle($title);
      $ticket->setAssignee($newassignee);
      $ticket->setRequester($newreq);
      $ticket->setStatus($status);
      $ticket->setPriority($priority);

      $entityManager->persist($ticket);
      $entityManager->persist($thr);

      $entityManager->flush();

        $data = '<h2 class="alert alert-success alert-dismissible">Ticket has been updated</h2>';
        $res = new Response(json_encode($data));
        $res->headers->set('Content-Type', 'application/json');
        return new Response($res);
    }

    public function AssignedTicket()
    {
       $usr = $this->getUser();
       $ticketrepository = $this->getDoctrine()->getRepository(Ticket::class);
       $id=$usr->getId();
       $Assigned = $ticketrepository->getAssignedTickets($id);

      return $this->render('agent/assignedtickettable.html.twig', array('ATickets' => $Assigned));
    }

}
