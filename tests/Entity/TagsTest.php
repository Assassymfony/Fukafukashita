<?php

namespace App\Tests\Entity;

use App\Entity\Tags;
use PHPUnit\Framework\TestCase;
use App\Entity\Post;

class TagsTest extends TestCase
{
    public function testGetId()
    {
        $tags = new Tags();
        $this->assertNull($tags->getId());
    }

    public function testGetSetName()
    {
        $tags = new Tags();
        $name = 'Test Tag';
        $tags->setName($name);

        $this->assertSame($name, $tags->getName());
    }

    public function testGetSetColor()
    {
        $tags = new Tags();
        $color = '#FF0000';
        $tags->setColor($color);

        $this->assertSame($color, $tags->getColor());
    }

    public function testAddRemovePost()
    {
        $tags = new Tags();
        $post = new Post();

        $tags->addPost($post);
        $this->assertTrue($tags->getPosts()->contains($post));

        $tags->removePost($post);
        $this->assertFalse($tags->getPosts()->contains($post));
    }
}
