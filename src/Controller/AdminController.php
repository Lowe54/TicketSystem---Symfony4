<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Ticket;
use Psr\Log\LoggerInterface;

class AdminController extends Controller{
  public function UserList()
  {
    $repository = $this->getDoctrine()->getRepository(User::class);
    $assignees = $repository->findBy(['isAgent' => 1]);
    $requesters = $repository->findBy(['isActive' => 1, 'isAgent' => 0]);

    return $this->render('admin/userlist.html.twig', array('agents' => $assignees, 'endusers' => $requesters));
  }
  /**
   *@Route("/admin/finduser", name="finduser")
   */
  public function findUser(Request $request, LoggerInterface $logger)
  {
    $uid = $request->request->get('id');
    $UPR = $this->getDoctrine()->getRepository(User::class);
    $uinfo = $UPR->findOneBy(array('id' => $uid));
    $response = $this->renderView('admin/userview.html.twig', array(
      'id' => $uinfo->getId(),
      'firstName' => $uinfo->getFirstName(),
      'surName' => $uinfo->getLastName(),
      'active' => $uinfo->isEnabled(),

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
  *@Route("/admin/deleteuser", name="deleteUser)
  */
  public function deleteUser(Request $request)
  {
   $id = $request->request->get('id');
   $repository = $this->getDoctrine()->getRepository(User::class');
   $u = $repository->findOneBy(array('id' => $id);
   
  }
}

?>
