<?php

namespace App\Controller;

use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomePageController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private ManagerRegistry $registry;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry){
        $this->entityManager = $entityManager;
        $this->registry = $registry;
    }
    /**
     * @Route("/", name="home", methods = {"GET"})
     */
    public function home(): Response
    {
        $posts = [
            new Posts('1','DH',false, 1, 100, 'Rêve 1', 'Je vais vivre', ["nul","boring"]),
            new Posts('2','DH',true, 500, 100, 'Rêve 2', 'Je vais me pendre', ["enfin","merci"]),
        ];
        return $this->render('default/homePage.html.twig', [
            'posts' => $posts,
        ]);
    }

    public function addPost(): Response
    {
        return $this->render('default/addPostPage.html.twig');
    }
}
