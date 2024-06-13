<?php

namespace App\Tests\Entity;

use App\Entity\Commentary;
use PHPUnit\Framework\TestCase;
use App\Entity\Post;
use App\Entity\Profil;

class CommentaryTest extends TestCase
{
    public function testGetId()
    {
        $commentary = new Commentary();
        $this->assertNull($commentary->getId());
    }

    public function testGetSetText()
    {
        $commentary = new Commentary();
        $text = 'This is a test commentary.';
        $commentary->setText($text);

        $this->assertSame($text, $commentary->getText());
    }

    public function testGetSetPost()
    {
        $commentary = new Commentary();
        $post = new Post();
        $commentary->setPost($post);

        $this->assertSame($post, $commentary->getPost());
    }

    public function testGetSetProfil()
    {
        $commentary = new Commentary();
        $profil = new Profil();
        $commentary->setProfil($profil);

        $this->assertSame($profil, $commentary->getProfil());
    }
}
