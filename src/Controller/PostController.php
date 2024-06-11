<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Entity\Profil;
use App\Form\Type\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    # DEBUG: Ne doit pas être laissé en production.
    #[Route('/post/all', name: 'all post', methods: ['GET'])]
    public function getAllPost(): Response
    {
        $posts = $this->em->getRepository(Post::class)->findAll();

        return $this->render('post/all.html.twig', [
            "posts" => $posts
        ]);
    }

    #[Route('/post/{id}',
        name: 'display post',
        methods: ['GET'],
        requirements: ['id' => '\d+'])]
    public function getPost(int $id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);

        if (!$post) {
            # Error 404 page
        }

        # Return twig
        return new Response();
    }

    #[Route('/post/new/', name: 'add_post', methods: ['GET', 'POST'])]
    public function addPost(Request $request): Response
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $form = $form->getData();

            $user = $this->getUser();

            $profil = new Profil();
            $profil->setId(11);
            $profil->setName("coucou");


            $post->setProfil($user);

            $this->em->persist($post);
            $this->em->flush();

            return new Response($user->getUserIdentifier());
        }

        return $this->render('post/new.html.twig', [
            'form' => $form,
        ]);

        # Handle error on data

    }

    #[Route('/post/{id}', name: 'remove_post', methods: ['DELETE'])]
    public function removePost(int $id): Response
    {
        $postRef = $this->em->getReference('Post', $id);
        $this->em->remove($postRef);
        $this->em->flush();

        return new Response();
    }
}
