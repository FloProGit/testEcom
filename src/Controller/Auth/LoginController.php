<?php




namespace App\Controller\Auth;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    public function index(AuthenticationUtils $authenticationUtils) :response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        if($error != null)
        {
            dd($error);
        }
//        // last username entered by the user

        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('Auth/login.html.twig',['last_username' => $lastUsername]);
    }



}
