<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }

    /**
     * @Route("/forum", name="forum")
     */
    public function forum(): Response
    {
        return $this->render('forum/forum.html.twig', [
            'controller_name' => 'AppController',
        ]);
    }
}
