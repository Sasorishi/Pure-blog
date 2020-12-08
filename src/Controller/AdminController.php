<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

use App\Entity\Article;
use App\Entity\Categoriesarticle;
use App\Entity\User;
use App\Entity\Administrator;
use App\Entity\Event;
use App\Entity\SubEvent;

use \DateTime;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/login", name="dashboard_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/admin/logout", name="dashboard_logout")
     */
    public function logout()
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AppController'
        ]);
    }

    /**
     * @Route("/admin/dashboard/article", name="dashboard_article")
     */
    public function article(Request $request): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Categoriesarticle::class)
            ->findAll();

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAllArticles();

        // dump($articles);

        if($request->request->count() > 0)
        {
            dump($request);
            
            // Get user id currently logged
            $idAdmin = $this->get('security.token_storage')->getToken()->getUser()->getIdadmin();

            $this->createArticle($request, $idAdmin);
            return $this->redirect($request->getUri());
        }
        
        return $this->render('admin/article.html.twig', [
            'controller_name' => 'AppController',
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    public function createArticle($request, $idAdmin) {
        // Get reference entity
        $admin = $this->getDoctrine()
            ->getRepository(Administrator::class)
            ->find($idAdmin);

        // Get reference entity
        $category = $this->getDoctrine()
        ->getRepository(Categoriesarticle::class)
        ->find($request->request->get('categories'));

        $date = new DateTime($request->request->get('date'));

        dump($request->files->get('thumbnail'));

        if($request->files->get('thumbnail') == NULL) 
        {
            dump("Resquest failed : thumbnail");
        }
        else
        {
            // Get filename
            $uploadFile = $request->files->get('thumbnail');
            $nameFile = $request->files->get('thumbnail')->getClientOriginalName();
        }

        // Check request if all champs isn't not empty or null
        $arr = array('title', 'lead', 'status', 'description', 'categories', 'date');
        foreach ($arr as $value) 
        {
            if (!empty($request->request->get($value))) 
            {
                dump("Resquest valided : ". $value);
                $addArticle = true;
            } 
            else
            {
                dump("Resquest failed : ". $value);
                $addArticle = false;
                break;
            }
        }

        if($addArticle == true) 
        {
            // Save new article
            $article = new Article();
            $article
                ->setTitle($request->request->get('title'))
                ->setLead($request->request->get('lead'))
                ->setStatus($request->request->get('status'))
                ->setContent($request->request->get('description'))
                ->setIdadmin($admin)
                ->setIdcategorie($category)
                ->setThumbnail($nameFile)
                ->setCreated($date);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            // Create personnal folder
            mkdir($this->getParameter('public_directory'). "/articles/" .$article->getIdarticle(), 0700);
    
            if(!$uploadFile)
            {
                throw new BadRequestHttpException('"File" is required');
            }
            else
            {
                $request->files->get('thumbnail')->move($this->getParameter('public_directory'). "/articles/" .$article->getIdarticle(), $nameFile);
            }
        }

    }

    /**
     * @Route("/admin/dashboard/delete/{id}", name="dashboard_delete_article")
     */
    public function deleteArticle($id) 
    {
        dump($id);
        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->find($id);

        dump($article);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();

        return $this->redirectToRoute('dashboard_article');
    }

    /**
     * @Route("/admin/dashboard/users", name="dashboard_user")
     */
    public function user(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        
        return $this->render('admin/user.html.twig', [
            'controller_name' => 'AppController',
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/dashboard/event", name="dashboard_event")
     */
    public function event(Request $request): Response
    {
        $events = $this->getDoctrine()
            ->getRepository(Event::class)
            ->findAll();

        dump($events);

        if($request->request->count() > 0)
        {
            dump($request);
            
            // Get user id currently logged
            $idAdmin = $this->get('security.token_storage')->getToken()->getUser()->getIdadmin();

            $this->createEvent($request, $idAdmin);
            return $this->redirect($request->getUri());
        }
        
        return $this->render('admin/event.html.twig', [
            'controller_name' => 'AppController',
            'events' => $events
        ]);
    }

    public function createEvent($request, $idAdmin) {
        // Get reference entity
        $admin = $this->getDoctrine()
            ->getRepository(Administrator::class)
            ->find($idAdmin);

        $date = new DateTime($request->request->get('date'));

        dump($request->files->get('thumbnail'));

        if($request->files->get('thumbnail') == NULL) 
        {
            dump("Resquest failed : thumbnail");
        }
        else
        {
            // Get filename
            $uploadFile = $request->files->get('thumbnail');
            $nameFile = $request->files->get('thumbnail')->getClientOriginalName();
        }

        // Check request if all champs isn't not empty or null
        $arr = array('title', 'description', 'date');
        foreach ($arr as $value) 
        {
            if (!empty($request->request->get($value))) 
            {
                dump("Resquest valided : ". $value);
                $addEvent = true;
            } 
            else
            {
                dump("Resquest failed : ". $value);
                $addEvent = false;
                break;
            }
        }

        if($addEvent == true) 
        {
            // Save new article
            $event = new Event();
            $event
                ->setTitle($request->request->get('title'))
                ->setContent($request->request->get('description'))
                ->setIdAdmin($admin)
                ->setThumbnail($nameFile)
                ->setCreated($date);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($event);
            $manager->flush();

            // Create personnal folder
            mkdir($this->getParameter('public_directory'). "/events/" .$event->getIdevent(), 0700);
    
            if(!$uploadFile)
            {
                throw new BadRequestHttpException('"File" is required');
            }
            else
            {
                $request->files->get('thumbnail')->move($this->getParameter('public_directory'). "/events/" .$event->getIdevent(), $nameFile);
            }
        }

    }

    /**
     * @Route("/admin/dashboard/delete/{id}", name="dashboard_delete_event")
     */
    public function deleteEvent($id) 
    {
        dump($id);
        $event = $this->getDoctrine()
            ->getRepository(Event::class)
            ->find($id);

        dump($event);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($event);
        $manager->flush();

        return $this->redirectToRoute('dashboard_event');
    }
}
