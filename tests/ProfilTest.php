<?php

use App\Entity\Profil;
use App\Entity\Post;
use App\Entity\Commentary;
use PHPUnit\Framework\TestCase;

class ProfilTest extends TestCase
{
    public function test_it_can_be_instantiated()
    {
        $profil = new Profil();
        $this->assertInstanceOf(Profil::class, $profil);
    }

    public function test_name()
    {
        $profil = new Profil();
        $profil->setName('John Doe');
        $this->assertEquals('John Doe', $profil->getName());
    }

    public function test_description()
    {
        $profil = new Profil();
        $profil->setDescription('Lorem ipsum');
        $this->assertEquals('Lorem ipsum', $profil->getDescription());
    }

    public function test_password()
    {
        $profil = new Profil();
        $profil->setPassword('password123');
        $this->assertEquals('password123', $profil->getPassword());
    }

    public function test_roles()
    {
        $profil = new Profil();
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];
        $profil->setRoles($roles);
        $this->assertEquals($roles, $profil->getRoles());
    }

    public function test_user_identifier()
    {
        $profil = new Profil();
        $profil->setName('johndoe');
        $this->assertEquals('johndoe', $profil->getUserIdentifier());
    }

    public function test_add_and_remove_post()
    {
        $profil = new Profil();
        $post = new Post(); 
        $profil->addPost($post);
        $this->assertTrue($profil->getPosts()->contains($post));

        $profil->removePost($post);
        $this->assertFalse($profil->getPosts()->contains($post));
    }

    public function test_add_and_remove_commentary()
    {
        $profil = new Profil();
        $commentary = new Commentary(); 
        $profil->addCommentary($commentary);
        $this->assertTrue($profil->getCommentaries()->contains($commentary));

        $profil->removeCommentary($commentary);
        $this->assertFalse($profil->getCommentaries()->contains($commentary));
    }

    public function test_add_and_remove_follower()
    {
        $profil1 = new Profil();
        $profil2 = new Profil();

        $profil1->addFollower($profil2);
        $this->assertTrue($profil1->getFollowers()->contains($profil2));

        $profil1->removeFollower($profil2);
        $this->assertFalse($profil1->getFollowers()->contains($profil2));
    }

    public function test_add_and_remove_following()
    {
        $profil1 = new Profil();
        $profil2 = new Profil();

        $profil1->addFollowing($profil2);
        $this->assertTrue($profil1->getFollowing()->contains($profil2));
        $this->assertTrue($profil2->getFollowers()->contains($profil1));

        $profil1->removeFollowing($profil2);
        $this->assertFalse($profil1->getFollowing()->contains($profil2));
        $this->assertFalse($profil2->getFollowers()->contains($profil1));
    }
}
