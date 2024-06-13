<?php

namespace App\Tests\Form;

use App\Form\RegistrationFormType;
use App\Entity\Profil;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class RegistrationFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'name' => 'Test Name',
            'agreeTerms' => true,
            'plainPassword' => 'testpassword',
        ];

        $form = $this->factory->create(RegistrationFormType::class);

        $objectToCompare = new Profil();

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($formData['name'], $form->get('name')->getData());
        $this->assertEquals($formData['agreeTerms'], $form->get('agreeTerms')->getData());
        $this->assertEquals($formData['plainPassword'], $form->get('plainPassword')->getData());

        $validator = Validation::createValidator();
        $violations = $validator->validate($objectToCompare);

        $this->assertCount(0, $violations);
    }

    public function testFormFields()
    {
        $form = $this->factory->create(RegistrationFormType::class);

        $this->assertTrue($form->has('name'));
        $this->assertTrue($form->has('agreeTerms'));
        $this->assertTrue($form->has('plainPassword'));
    }
}
