<?php

namespace App\Tests\Form;

use App\Form\ProfilType;
use App\Entity\Profil;
use Symfony\Component\Form\Test\TypeTestCase;

class ProfilTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'name' => 'Test Name',
            'description' => 'Lorem ipsum dolor sit amet.',
        ];

        $objectToCompare = new Profil();

        $form = $this->factory->create(ProfilType::class, $objectToCompare);

        $object = new Profil();
        $object->setName('Test Name');
        $object->setDescription('Lorem ipsum dolor sit amet.');

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($object, $objectToCompare);
    }

    public function testFormFields()
    {
        $form = $this->factory->create(ProfilType::class);

        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('description'));
    }
}
