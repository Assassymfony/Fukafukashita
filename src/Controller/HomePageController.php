<?php

namespace App\Controller;

use App\Entity\HomePageEntity;
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
     * @Route("/home", name="home", methods = {"GET"})
     */
    public function home(): Response
    {
        $posts = [
            new HomePageEntity('Rêve 1', 'J\'ai rếvé que Corentin était beau (impossible)'),
            new HomePageEntity('Rêve 2', 'J\'ai rếvé que Rémi est moche (impossible)'),
        ];
        return $this->render('default/homePage.html.twig', [
            'posts' => $posts,
        ]);
    }
}
