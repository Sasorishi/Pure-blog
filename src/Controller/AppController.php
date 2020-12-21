<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

use App\Entity\Categoriesforum;
use App\Entity\Topics;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Event;

use \DateTime;

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

        return $this->render('forum/forum.html.twig', [
            'controller_name' => 'AppController',
            'categoriesForum' => $categoriesForum
        ]);
    }

    /**
     * @Route("/forum/{id}/{topics}", name="topics")
     */
    public function topics($id, $topics, Request $request, Security $security): Response
    {
        $topics = $this->getDoctrine()
            ->getRepository(Topics::class)
            ->findByCategories($id);

        if($request->request->count() > 0)
        {
            // Get user id currently logged
            $idUser = $this->get('security.token_storage')->getToken()->getUser()->getIduser();

            $this->createTopics($request, $id, $idUser);
            return $this->redirect($request->getUri());
        }

        return $this->render('forum/topics.html.twig', [
            'controller_name' => 'AppController',
            'topics' => $topics
        ]);
    }

    public function createTopics($request, $idCategory, $idUser)
    {
        dump($request);

        // Get reference entity
        $category = $this->getDoctrine()
            ->getRepository(Categoriesforum::class)
            ->find($idCategory);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($idUser);

        // Save new topics
        $topics = new Topics();
        $topics
            ->setTopics($request->request->get('title'))
            ->setIdcategorie($category)
            ->setIduser($user);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($topics);
        $manager->flush();

        $idTopics = $topics->getIdTopics();
        $this->createPost($request, $idUser, $idTopics);
    }

    public function createPost($request, $idUser, $idTopics)
    {
        // Set default timezone
        date_default_timezone_set('Europe/Paris');
        $date = new DateTime();

        // Get reference entity
        $topics = $this->getDoctrine()
            ->getRepository(Topics::class)
            ->find($idTopics);

        // Get reference entity
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($idUser);

        // Save new post
        $post = new Post();
        $post
            ->setContent($request->request->get('message'))
            ->setIduser($user)
            ->setIdtopics($topics)
            ->setCreated($date);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($post);
        $manager->flush();

        return new Response('Topics created');
    }

    /**
     * @Route("/forum/{id}_{topics}", name="post")
     */
    public function post(Request $request, Security $security, $id, $topics): Response
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findByTopics($id);

        dump($posts);
        
        if($request->request->count() > 0)
        {
            // Get user id currently logged
            $idUser = $this->get('security.token_storage')->getToken()->getUser()->getIduser();

            $this->createPost($request, $idUser, $id);
            return $this->redirect($request->getUri());
        }

        return $this->render('forum/post.html.twig', [
            'controller_name' => 'AppController',
            'topics' => $topics,
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        dump($articles);

        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'AppController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/blog/article/{id}", name="blog_article")
     */
    public function article(Request $request, $id): Response
    {
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findById($id);

        if(!$article) 
        {
            throw $this->createNotFoundException(
                'No article found for id '.$id
            );
        }

        dump($article);

        return $this->render('blog/article.html.twig', [
            'controller_name' => 'AppController',
            'article' => $article
        ]);
    }

    /**
     * @Route("/blog/event/{id}", name="blog_event")
     */
    public function event(Request $request, $id): Response
    {
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);


        return $this->render('blog/event.html.twig', [
            'controller_name' => 'AppController',
            'event' => $event
        ]);
    }

}
