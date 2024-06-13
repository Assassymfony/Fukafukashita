<?php

use App\Entity\Commentary;
use App\Entity\Post;
use App\Entity\Profil;
use PHPUnit\Framework\TestCase;

class CommentaryTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $commentary = new Commentary();
        $this->assertInstanceOf(Commentary::class, $commentary);
    }

    public function test_text()
    {
        $commentary = new Commentary();
        $commentary->setText('Lorem ipsum');
        $this->assertEquals('Lorem ipsum', $commentary->getText());
    }

    public function test_post_association()
    {
        $commentary = new Commentary();
        $post = new Post(); // Assuming Post is properly defined
        $commentary->setPost($post);
        $this->assertInstanceOf(Post::class, $commentary->getPost());
    }

    public function test_profil_association()
    {
        $commentary = new Commentary();
        $profil = new Profil(); // Assuming Profil is properly defined
        $commentary->setProfil($profil);
        $this->assertInstanceOf(Profil::class, $commentary->getProfil());
    }
}
