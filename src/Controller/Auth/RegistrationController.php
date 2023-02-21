<?php


namespace App\Controller\Auth;



use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine)
    {

    }
    public function  index() : Response
    {
        return $this->render('Auth/registration.html.twig');
    }
   public function create(Request $request, UserPasswordHasherInterface $passwordHasher,ValidatorInterface $validator) : Response
   {

       $user = new User();

       $user->setPlainPassword($request->request->get('password'));
       $user->setConfirmPassword($request->request->get('confirm-password'));
       $user->setUserName($request->request->get('user-name'));
       $user->setEmail($request->request->get('email-address'));
       $user->setRoles([]);
       $user->setCreatedAt(new \DateTimeImmutable());

       $errors = $validator->validate($user);

       if (count($errors) > 0) {
           /*
            * Uses a __toString method on the $errors variable which is a
            * ConstraintViolationList object. This gives us a nice string
            * for debugging.
            */
           $errorsString = (string) $errors;
            $errorArray = [];
           foreach ($errors as $error)
           {
               $errorArray[$error->getPropertyPath()] = $error->getMessage();
           }

           return $this->render('Auth/registration.html.twig',[ 'errors' => $errorArray]);


       }

       $entityManager = $this->doctrine->getManager();
       $entityManager->persist($user);

       $entityManager->flush();

        return  $this->redirectToRoute('waiting_mail_validation');

   }

   public function waitingMailValidation(): Response
   {
       return $this->render('Auth/wait_mail_validation.html.twig');
   }

}
