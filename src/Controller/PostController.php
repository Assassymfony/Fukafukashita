<?php

namespace App\Controller;

use App\Entity\Commentary;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Form\Type\PostType;
use App\Form\CommentType;
use App\Form\Type\SimpleSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em){}

    #[Route('/', name: 'all_posts', methods: ['GET'])]
    public function getAllPost(): Response
    {
        $posts = $this->em->getRepository(Post::class)->findAll();

        return $this->render('post/all.html.twig', [
            "posts" => array_reverse($posts),
            "title" => "Derniers Posts"
        ]);
    }

    #[Route(
        '/post/{id}',
        name: 'display_post',
        requirements: ['id' => '\d+'],
        methods: ['GET', 'POST']
    )]
    public function getPost(int $id, Request $request): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);

        $comment = new Commentary();
        $commentForm = $this->createForm(CommentType::class, $comment);

        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $user = $this->getUser();

            $comment->setProfil($user);
            $comment->setPost($post);

            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('display_post', ['id' => $id]);
        }

        return $this->render('post/post.html.twig', [
            'post' => $post,
            'commentForm' => $commentForm,
        ]);
    }

    #[Route('/post/new/', name: 'add_post', methods: ['GET', 'POST'])]
    public function addPost(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$dateNow = new DateTime();
            
            $form = $form->getData();
            $user = $this->getUser();
            $post->setProfil($user);

            $this->em->persist($post);
            $this->em->flush();

            return $this->redirectToRoute('display_post', ['id' => $post->getId()]);
        }

        return $this->render('post/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/post/{id}', name: 'remove_post', methods: ['DELETE'])]
    public function removePost(int $id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);
        if($post->getProfil()->getId() === $this->getUser()->getId())
        {
            $this->em->remove($post);
            $this->em->flush();
        }
        return new Response();
    }

    #[Route('/post/{id}/comment', name: 'post_comment', methods: ['POST'])]
    public function addComment(int $id, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $comment = new Commentary();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $this->em->getRepository(Post::class)->find($id);
            
            $form = $form->getData();
            $user = $this->getUser();

            $comment->setProfil($user);
            $comment->setPost($post);

            $this->em->persist($comment);
            $this->em->flush();

            return $this->redirectToRoute('display_post', ['id' => $id]);
        }

        return $this->render('post/new.html.twig', [
            'form' => $form,
        ]);
    }
    
    #[Route('/post/search', name: 'search_post', methods: ['GET', 'POST'])]
    public function searchPost(Request $request): Response
    {
        $form = $this->createForm(SimpleSearchType::class);

        $form->handleRequest($request);        
        if ($form->isSubmitted() && $form->isValid()) {
            $searchString = $form->get('search')->getData();
            $posts = $this->em->getRepository(Post::class)->searchByTitleOrText($searchString);

            return $this->render('post/search.html.twig', [
                'posts' => $posts,
                'form' => $this->createForm(SimpleSearchType::class)
            ]);

            // return new Response(print_r($posts, true));
        }

        return $this->render('post/search.html.twig', [
                'form' => $form
        ]);
    } 
}
