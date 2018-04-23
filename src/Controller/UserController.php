<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller{
    /**
     *@Route("/user/dashboard", name="userDashboard")
     */
    public function User_Dashboard()
    {
        return $this->render('user/userdashboard.html.twig');
    }
}

