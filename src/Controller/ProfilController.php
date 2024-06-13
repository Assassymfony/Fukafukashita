<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManager;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends AbstractController
{


    public function __construct(private EntityManager $mgr, private PostRepository $postRepository)
    {
    }
    #[Route(path: "/profil", name: "profil_perso", methods: ["GET"])]
    public function baseProfil(): Response
    {
        try {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        } catch (\Exception $e) {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('profil_show', ['id' => $this->getUser()->getId()]);
    }
    #[Route('/profil/{id}', name: 'profil_show', requirements: ['page' => '\d+'])]
    public function profil(int $id): Response
    {
        $connected = $this->isGranted('ROLE_USER');
        // $connected = $this->isGranted('ROLE_USER') != false;

        $profil = $this->mgr->find(Profil::class, $id);
        $posts = $profil->getPosts();
        return $this->render('profil/index.html.twig', [
            'profil' => $profil,
            'posts' => $posts,
            'followFlag' => $profil->getFollowers()->contains($this->getUser()),
            'selfFlag' => $profil == $this->getUser(),
            'connected' => $connected
        ]);
    }


    #[Route('/profil/post/follow', name: 'profil_post_follow')]
    public function postProfilfollow(): Response
    {
        try{
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        }catch (\Exception $e){
            return $this->redirectToRoute('app_login');
        }
        $profil = $this->getUser();
        $posts = $this->postRepository->getPostFromFollowed($profil);
        return $this->render('post/all.html.twig', [
            "posts" => $posts,
            "title" => "Abonnements"
        ]);
    }

    #[Route('/profil/{id}/unfollow', name: 'profil_unfollow', requirements: ['page' => '\d+'])]
    public function unfollowProfil(int $id): Response
    {
        try{
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        }catch (\Exception $e){
            return $this->redirectToRoute('app_login');
        }
        
        $profil = $this->mgr->find(Profil::class, $id);
        if ($profil instanceof Profil) {
            $profil->removeFollower($this->getUser());
            $this->mgr->persist($profil);
            $this->mgr->flush();
            $this->addFlash('success', '');
            return $this->redirectToRoute('profil_show', ['id' => $id]);
        } else {
            $this->addFlash('error', '');
            return $this->render('error.html.twig', []);
        }
    }

    #[Route('/profil/{id}/followers', name: 'profil_followers', requirements: ['page' => '\d'])]
    public function getFollowers(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);

        return $this->render('profil/follow-list.html.twig', [
            'title' => 'Followers',
            'profils' => $profil->getFollowers()
        ]);
    }

    #[Route('/profil/{id}/following', name: 'profil_following', requirements: ['page' => '\d'])]
    public function getFollowing(int $id): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);

        return $this->render('profil/follow-list.html.twig', [
            'title' => 'Following',
            'profils' => $profil->getFollowing()
        ]);
    }

    #[Route('/profil/{id}/edit', name: 'profil_edit', requirements: ['page' => '\d'])]
    public function editProfil(int $id, Request $request): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);

        $form = $this->createForm(ProfilType::class, $profil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $this->mgr->persist($profil);
            $this->mgr->flush();

            return $this->redirectToRoute('profil_show', ['id' => $id]);
        }

        return $this->render('profil/edit.html.twig', [
            'form' => $form,
            'profil' => $profil,
        ]);
    }

    #[Route('/profil/{id}/follow', name: 'profil_follow', requirements: ['page' => '\d+'])]
    public function followProfil(int $id): Response
    {
        try{
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        }catch (\Exception $e){
            return $this->redirectToRoute('app_login');
        }
        $profil = $this->mgr->find(Profil::class, $id);

        if ($profil instanceof Profil) {
            if ($profil->getId() !== $this->getUser()->getId()) {
                $profil->addFollower($this->getUser());
                $this->mgr->persist($profil);
                $this->mgr->flush();
                $this->addFlash('success', '');
            }
            return $this->redirectToRoute('profil_show', ['id' => $id]);
        } else {
            $this->addFlash('error', '');
            return $this->render('error.html.twig', []);
        }
    }

    #[Route('/profil/{id}/delete', name: 'profil_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(int $id, Request $request): Response
    {
        $profil = $this->mgr->find(Profil::class, $id);

        if (!$profil) {
            throw $this->createNotFoundException('The profile does not exist');
        }

        if ($this->isCsrfTokenValid('delete' . $profil->getId(), $request->request->get('_token'))) {
            $this->mgr->remove($profil);
            $this->mgr->flush();
            $this->addFlash('success', 'Profile deleted successfully');
        }

        return $this->redirectToRoute('app_login');
    }


}
