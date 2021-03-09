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
use Knp\Component\Pager\PaginatorInterface;

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
        $category = $topics;

        $topics = $this->getDoctrine()
            ->getRepository(Topics::class)
            ->findByCategories($id);
        
        $topics = $this->getDoctrine()
            ->getRepository(Topics::class)
            ->findAllTopics($id);

        dump($topics);

        if($request->request->count() > 0)
        {
            // Get user id currently logged
            $idUser = $this->get('security.token_storage')->getToken()->getUser()->getIduser();

            $this->createTopics($request, $id, $idUser);
            return $this->redirect($request->getUri());
        }

        return $this->render('forum/topics.html.twig', [
            'controller_name' => 'AppController',
            'topics' => $topics,
            'category' => $category
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

        dump($user->getIduser());

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
        // Get reference entity
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findByTopics($id);

        // Get reference entity
        $categorie = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findCategorieName($id);

        $categorieName = $categorie[0];
        // dump($categorieName);
        
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
            'posts' => $posts,
            'categorieName' => $categorieName
        ]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog(Request $request, PaginatorInterface $paginator): Response
    {
        $listArticles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAllArticles();

        $articles = $paginator->paginate(
            $listArticles, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            10 // Nombre de résultats par page
        );

        $event = $this->getDoctrine()
        ->getRepository(Event::class)
        ->findLastEvent();

        dump($event);

        return $this->render('blog/blog.html.twig', [
            'controller_name' => 'AppController',
            'articles' => $articles,
            'event' => $event
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

    /**
     * @Route("/ethique-et-santé", name="ethic")
     */
    public function ethic(): Response
    {

        return $this->render('home/ethic.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/social-et-solidaire", name="social")
     */
    public function social(): Response
    {

        return $this->render('home/social.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/ecologique-et-impact-environnemental", name="ecology")
     */
    public function ecology(): Response
    {

        return $this->render('home/ecology.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/coup-de-coeur", name="brandLiked")
     */
    public function brandLiked(): Response
    {
        return $this->render('home/brandLiked.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/aemium", name="aemium")
     */
    public function aemium(): Response
    {
        return $this->render('brands/aemium.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/aimée-de-mars", name="aimée-de-mars")
     */
    public function aimeeDeMars(): Response
    {
        return $this->render('brands/aimée-de-mars.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/ajnalogie", name="ajnalogie")
     */
    public function ajnalogie(): Response
    {
        return $this->render('brands/ajnalogie.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/bastille", name="parfums-bastille")
     */
    public function bastille(): Response
    {
        return $this->render('brands/parfums-bastilles.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/essential-parfum", name="essential-parfum")
     */
    public function essentialParfum(): Response
    {
        return $this->render('brands/essential-parfums.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/floratropia", name="floratropia")
     */
    public function floratropia(): Response
    {
        return $this->render('brands/floratropia.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/honoré-des-prés", name="honoré-des-prés")
     */
    public function honoreDesPrés(): Response
    {
        return $this->render('brands/honoré-des-prés.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/obvious", name="obvious")
     */
    public function obvious(): Response
    {
        return $this->render('brands/obvious.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/ormaie", name="ormaie")
     */
    public function ormaie(): Response
    {
        return $this->render('brands/ormaie.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/parfumeur-du-monde", name="parfumeur-du-monde")
     */
    public function parfumeurDuMonde(): Response
    {
        return $this->render('brands/parfumeurs-du-monde.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/ph-fragrances", name="ph-fragrances")
     */
    public function phFragrances(): Response
    {
        return $this->render('brands/ph-fragrances.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/tolteca", name="tolteca")
     */
    public function tolteca(): Response
    {
        return $this->render('brands/tolteca.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/100Bon", name="100Bon")
     */
    public function Bon(): Response
    {
        return $this->render('brands/100Bon.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/acorelle", name="acorelle")
     */
    public function acorelle(): Response
    {
        return $this->render('brands/Acorelle.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/maison-sybarite", name="maison-sybarite")
     */
    public function maisonSybarite(): Response
    {
        return $this->render('brands/maison-sybarite.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/le-couvent", name="le-couvent")
     */
    public function leCouvent(): Response
    {
        return $this->render('brands/le-couvent.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }
}
