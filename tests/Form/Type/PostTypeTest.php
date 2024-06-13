<?php

namespace App\Tests\Form\Type;

use App\Form\Type\PostType;
use Symfony\Component\Form\Test\TypeTestCase;

class PostTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'Test Title',
            'text' => 'Lorem ipsum dolor sit amet.',
            'dream' => true,
        ];

        $form = $this->factory->create(PostType::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData['title'], $form->get('title')->getData());
        $this->assertEquals($formData['text'], $form->get('text')->getData());
        $this->assertEquals($formData['dream'], $form->get('dream')->getData());
    }

    public function testFormFields()
    {
        $form = $this->factory->create(PostType::class);

        $this->assertTrue($form->has('title'));
        $this->assertTrue($form->has('text'));
        $this->assertTrue($form->has('dream'));
        $this->assertTrue($form->has('submit'));
    }
}
