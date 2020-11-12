<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
            dump($request);

            $user = new User();

            $plainPassword = $request->request->get('password');
            $encoded = $encoder->encodePassword($user, $plainPassword);

            $user->setFirstname($request->request->get('firstName'))
                ->setLastname($request->request->get('lastName'))
                ->setSexe($request->request->get('sexe'))
                ->setEmail($request->request->get('email'))
                ->setPassword($encoded);

            $manager->persist($user);
            $manager->flush();
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
