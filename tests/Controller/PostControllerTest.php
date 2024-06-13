<?php

namespace App\Tests\Controller;

use App\Entity\Profil;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Post;
class PostControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private mixed $em;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->em = static::getContainer()->get(EntityManagerInterface::class);
    }


    public function testGetPost()
    {
        $post = new Post();
        $post->setTitle('Test Post');
        $post->setText('This is a test post.');
        $post->setId(66666);
        $post->setProfil($this->createUser());
        $post->setDream(true);
        $this->em->persist($post);
        $this->em->flush();

        $crawler = $this->client->request('GET', '/post/' . $post->getId());

        $this->assertResponseIsSuccessful();
    }


    public function testAddPost()
    {
        $this->client->loginUser($this->createUser());

        $crawler = $this->client->request('GET', '/post/new/');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Submit')->form([
            'post[title]' => 'New Post',
            'post[text]' => 'Content of the new post',
        ]);

        $this->client->submit($form);

        $post = $this->em->getRepository(Post::class)->findOneBy(['title' => 'New Post']);
        $this->assertNotNull($post);
    }

    public function testRemovePost()
    {
        $post = new Post();
        $post->setTitle('Post to be deleted');
        $post->setText('This post will be deleted.');
        $post->setProfil($this->createUser());
        $post->setDream(true);
        $this->em->persist($post);
        $this->em->flush();
        $postId = $post->getId();
        $this->client->request('DELETE', '/post/' . $postId);
        $this->assertNull($this->em->getRepository(Post::class)->find($postId));
    }


    private function createUser(): Profil
    {
        $user = new Profil();
        $user->setName('testuser');
        $user->setPassword(password_hash('password', PASSWORD_BCRYPT));
        $user->setId(666666);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
