<?php
// src/Controller/indexController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Psr\Log\LoggerInterface;

class indexController extends Controller{
    /**
     * @Route("/", name="index")
     * @param \App\Controller\request $request
     * @return Response
     */
    public function index(AuthenticationUtils $authUtils, LoggerInterface $logger)
    {
        
            // get the login error if there is one
            $error = $authUtils->getLastAuthenticationError();
            

            // last username entered by the user
            $lastUsername = $authUtils->getLastUsername();
            return $this->render('main/index.html.twig',array(
                 'last_username' => $lastUsername,
                 'error'         => $error,));
            
        
    }
    /**
     * @Route("/check_roles")
     */
    public function checkRoles()
    {
        $user = $this->getUser();
        
        $agent = $user->getIsAgent();
        //ToDo: Admin Check
        if($agent == null)
        {
            return $this->redirectToRoute('userDashboard');
        }
        else
        {
           return $this->redirectToRoute('agentDashboard');
        }
        
        
    }
    
    
    
    
       
    
    
}
