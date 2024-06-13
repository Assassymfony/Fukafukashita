<?php

namespace App\Tests\Entity;

use App\Entity\Post;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use App\Entity\Profil;
use App\Entity\Commentary;
use App\Entity\Tags;

class PostTest extends TestCase
{
    public function testGetId()
    {
        $post = new Post();
        $this->assertNull($post->getId());
    }

    public function testGetSetTitle()
    {
        $post = new Post();
        $title = 'Test Title';
        $post->setTitle($title);

        $this->assertSame($title, $post->getTitle());
    }

    public function testGetSetText()
    {
        $post = new Post();
        $text = 'This is a test post.';
        $post->setText($text);

        $this->assertSame($text, $post->getText());
    }

    public function testGetSetIsDream()
    {
        $post = new Post();
        $post->setDream(true);

        $this->assertTrue($post->isDream());
    }

    public function testGetSetUpVote()
    {
        $post = new Post();
        $post->setUpVote(10);

        $this->assertSame(10, $post->getUpVote());
    }

    public function testGetSetDownVote()
    {
        $post = new Post();
        $post->setDownVote(5);

        $this->assertSame(5, $post->getDownVote());
    }

    public function testGetSetProfil()
    {
        $post = new Post();
        $profil = new Profil();
        $post->setProfil($profil);

        $this->assertSame($profil, $post->getProfil());
    }

    public function testAddRemoveCommentary()
    {
        $post = new Post();
        $commentary = new Commentary();

        $post->addCommentary($commentary);
        $this->assertTrue($post->getCommentaries()->contains($commentary));

        $post->removeCommentary($commentary);
        $this->assertFalse($post->getCommentaries()->contains($commentary));
    }

    public function testAddRemoveTag()
    {
        $post = new Post();
        $tag = new Tags();

        $post->addTag($tag);
        $this->assertTrue($post->getTags()->contains($tag));

        $post->removeTag($tag);
        $this->assertFalse($post->getTags()->contains($tag));
    }

    public function testGetSetCreatedAt()
    {
        $post = new Post();
        $createdAt = new DateTimeImmutable('now');
        $post->setCreatedAt($createdAt);

        $this->assertSame($createdAt, $post->getCreatedAt());
    }
}
