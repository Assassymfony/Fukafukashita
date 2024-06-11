<?php

namespace App\Controller;

use App\Entity\Profil;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfilController extends AbstractController
{
    private Profil $currentProfil;

    public function __construct(private EntityManager $mgr)
    {
    }

    #[Route('/profil/{id}',name:'profil_show', requirements: ['page' => '\d+'])]
    public function profil(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);
        $posts = $profil->getPosts();
        return $this->render('profil/index.html.twig', [
            'profil' => $profil,
            'posts' => $posts,
            'followFlag' => $profil->getFollowers()->contains($this->getUser()),
            'selfFlag' => $profil != $this->getUser()
        ]);
    }

    #[Route('/profil/{id}/follow',name:'profil_follow', requirements: ['page' => '\d+'])]
    public function followProfil(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);
        if ($profil instanceof Profil) {
            $profil->addFollower($this->getUser());
            $this->mgr->persist($profil);
            $this->mgr->flush();
            $this->addFlash('success','');
            return $this->redirectToRoute('profil_show', ['id' => $id]);
        } else {
            $this->addFlash('error','');
            return $this->render('error.html.twig', []);
        }
    }

    #[Route('/profil/{id}/unfollow',name:'profil_unfollow', requirements: ['page' => '\d+'])]
    public function unfollowProfil(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);
        if ($profil instanceof Profil) {
            $profil->removeFollower($this->getUser());
            $this->mgr->persist($profil);
            $this->mgr->flush();
            $this->addFlash('success','');
            return $this->redirectToRoute('profil_show', ['id' => $id]);
        } else {
            $this->addFlash('error','');
            return $this->render('error.html.twig', []);
        }
    }

    #[Route('/profil/{id}/followers',name:'profil_followers', requirements: ['page'=> '\d'])]
    public function getFollowers(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);

        return $this->render('profil/follow-list.html.twig', [
            'title'=> 'Followers',
            'profils' => $profil->getFollowers()
            ]);
    }

    #[Route('/profil/{id}/following',name:'profil_following', requirements: ['page'=> '\d'])]
    public function getFollowing(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);

        return $this->render('profil/follow-list.html.twig', [
            'title'=> 'Following',
            'profils' => $profil->getFollowing()
            ]);
    }

    #[Route('/profil/new', name: 'profil_new')]
    public function new(): Response
    {
        $profil = new Profil();

        return $this->redirectToRoute('profil_show', ['id' => $profil->getId()]);
    }



}
