<?php

namespace App\Controller;

use App\Entity\Profil;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    private Profil $curentUser;

    public function __construct(private EntityManager $mgr)
    {
    }

    #[Route('/profil/{id}', requirements: ['page' => '\d+'])]
    public function profil(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);
        $posts = $profil->getPosts();
        return $this->render('profil/index.html.twig', [
            'profil' => $profil,
            'posts' => $posts
        ]);
    }

    #[Route('/profil/{id}/follow', requirements: ['page' => '\d+'])]
    public function followProfil(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);
        if ($profil instanceof Profil) {
            $profil->addFollower($this->curentUser);
            return $this->render('profil/index.html.twig', [
            ]);
        } else {
            return $this->render('error.html.twig', []);
        }
        // $profil = $this->mgr->find(Profil::class,$id);
        // 'profil' => $profil
    }

    #[Route('/profil/new', name: 'profil_new')]
    public function new(): Response
    {
        $profil = new Profil();

        return $this->redirectToRoute('profil_show', ['id' => $profil->getId()]);
    }



}
