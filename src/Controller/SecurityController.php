<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('forum/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/signin", name="signin")
     */
    public function signin(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        if($request->isMethod('POST'))
        {
            // Check request if all champs isn't not empty or null
            $arr = array('firstName', 'lastName', 'sexe', 'email', 'password');
            foreach ($arr as $value) 
            {
                if (!empty($request->request->get($value))) 
                {
                    dump("Resquest valided : ". $value);
                    $addUser = true;
                } 
                else
                {
                    dump("Resquest failed : ". $value);
                    $addUser = false;
                    break;
                }
            }

            // Insert new user
            if($addUser == true)
            {
                $user = new User();

                // Encode password
                $plainPassword = $request->request->get('password');
                $encoded = $encoder->encodePassword($user, $plainPassword);

                // Get filename
                $uploadFile = $request->files->get('avatar');
                $nameFile = $request->files->get('avatar')->getClientOriginalName();
    
                $user->setFirstname($request->request->get('firstName'))
                    ->setLastname($request->request->get('lastName'))
                    ->setSexe($request->request->get('sexe'))
                    ->setEmail($request->request->get('email'))
                    ->setAvatar($nameFile)
                    ->setPassword($encoded);
    
                $manager->persist($user);
                $manager->flush();
                
                // Create personnal folder
                mkdir($this->getParameter('public_directory'). "/users/" .$user->getIduser(), 0700);
    
                if(!$uploadFile)
                {
                    throw new BadRequestHttpException('"File" is required');
                }
                else
                {
                    $request->files->get('avatar')->move($this->getParameter('public_directory'). "/users/" .$user->getIduser(), $nameFile);
                }

                return $this->redirect('login');
            }
        }

        return $this->render('forum/signin.html.twig');
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
