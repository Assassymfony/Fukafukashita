<?php

namespace App\Tests\Entity;

use App\Entity\Profil;
use PHPUnit\Framework\TestCase;
use App\Entity\Post;
use App\Entity\Commentary;

class ProfilTest extends TestCase
{
    public function testGetId()
    {
        $profil = new Profil();
        $this->assertNull($profil->getId());
    }

    public function testGetSetName()
    {
        $profil = new Profil();
        $name = 'TestUser';
        $profil->setName($name);

        $this->assertSame($name, $profil->getName());
    }

    public function testGetSetDescription()
    {
        $profil = new Profil();
        $description = 'This is a test description.';
        $profil->setDescription($description);

        $this->assertSame($description, $profil->getDescription());
    }

    public function testGetSetPassword()
    {
        $profil = new Profil();
        $password = 'password123';
        $profil->setPassword($password);

        $this->assertSame($password, $profil->getPassword());
    }

    public function testAddRemovePost()
    {
        $profil = new Profil();
        $post = new Post();

        $profil->addPost($post);
        $this->assertTrue($profil->getPosts()->contains($post));

        $profil->removePost($post);
        $this->assertFalse($profil->getPosts()->contains($post));
    }

    public function testAddRemoveCommentary()
    {
        $profil = new Profil();
        $commentary = new Commentary();

        $profil->addCommentary($commentary);
        $this->assertTrue($profil->getCommentaries()->contains($commentary));

        $profil->removeCommentary($commentary);
        $this->assertFalse($profil->getCommentaries()->contains($commentary));
    }

    public function testGetSetRoles()
    {
        $profil = new Profil();
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $profil->setRoles($roles);

        $this->assertSame($roles, $profil->getRoles());
    }

    public function testAddRemoveFollower()
    {
        $profil1 = new Profil();
        $profil2 = new Profil();

        $profil1->addFollower($profil2);
        print_r($profil1->getFollowing());
        $this->assertTrue($profil1->getFollowers()->contains($profil2));
        $this->assertTrue($profil2->getFollowing()->contains($profil1));

        $profil1->removeFollower($profil2);
        $this->assertFalse($profil1->getFollowers()->contains($profil2));
        $this->assertFalse($profil2->getFollowing()->contains($profil1));
    }

    public function testAddRemoveFollowing()
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

