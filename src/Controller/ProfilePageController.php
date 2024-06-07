<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProfilePageController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    private ManagerRegistry $registry;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry){
        $this->entityManager = $entityManager;
        $this->registry = $registry;
    }
    /**
     * @Route("/user", name="user", methods = {"GET"})
     */
    public function user(): Response
    {
        $user = new User('DH','493', 'pp de fou','J\'aime pas vivre');
        return $this->render('default/profile.html.twig', [
            'user' => $user,
        ]);
    }
}