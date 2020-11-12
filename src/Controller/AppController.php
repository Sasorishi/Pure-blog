<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Categoriesforum;
use App\Entity\Topics;

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
        $categoriesForum = $this->getDoctrine()
            ->getRepository(Categoriesforum::class)
            ->findAll();

        dump($categoriesForum);

        return $this->render('forum/forum.html.twig', [
            'controller_name' => 'AppController',
            'categoriesForum' => $categoriesForum
        ]);
    }

    /**
     * @Route("/forum/{id}/{topics}", name="topics")
     */
    public function topics($id, $topics): Response
    {
        $topics = $this->getDoctrine()
            ->getRepository(topics::class)
            ->findByCategories($id);

        dump($topics);

        return $this->render('forum/topics.html.twig', [
            'controller_name' => 'AppController',
            'topics' => $topics
        ]);
    }
}
