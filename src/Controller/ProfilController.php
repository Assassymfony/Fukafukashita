<?php

namespace App\Controller;

use App\Entity\Profil;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{

    public function __construct(private EntityManager $mgr) {}

    #[Route('/profil/{id}',requirements: ['page' => '\d+'])]
    public function profil(int $id): Response    
    {   
        $profil = $this->mgr->find(Profil::class,$id);
        return $this->render('profil/index.html.twig', [
            'profil' => $profil
        ]);
    }

    #[Route('/profil/{id}/follow',requirements: ['page' => '\d+'])]
    public function followProfil(int $id): Response    
    {   
        // $profil = $this->mgr->find(Profil::class,$id);
        return $this->render('profil/index.html.twig', [
            // 'profil' => $profil
        ]);
    }



}
