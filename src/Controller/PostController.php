<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use Symfony\Component\Serializer\Serializer;

class PostController {

    private EntityManagerInterface $em;
    private Serializer $serializer;

    public function __construct(EntityManagerInterface $em, Serializer $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }
    
    #[Route('/post/{id}', name: 'display post', methods: ['GET'])]
    public function getPost(int $id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);

        if(!$post) {
            # Error 404 page
        }

        # Return twig
        return new Response();
    }

    #[Route('/post/', name: 'add_post', methods: ['POST'])]
    public function addPost(Request $request) :Response
    {
        $data = json_decode($request->getContent(), true);
        
        try {
            $post = $this->serializer->deserialize($data, Post::class, 'json');
        } catch (\Exception) {
            return new Response("Invalid JSON data", Response::HTTP_BAD_REQUEST);
        }

        # Handle error on data
        $this->em->persist($post);
        $this->em->flush();
                
        return new Response();
    }

    #[Route('/post/{id}', name: 'remove_post', methods: ['DELETE'])]
    public function removePost(int $id) :Response
    {
        $postRef = $this->em->getReference('Post', $id);
        $this->em->remove($postRef);
        $this->em->flush();

        return new Response();
    }
}
