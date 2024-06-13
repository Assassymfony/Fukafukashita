<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('text', TextareaType::class, [
                    'attr' => ['rows' => '10'],
                    'label' => 'Your dream'
            ])
            ->add('dream', CheckboxType::class, [
                    'required' => false,
                    'label' => 'Was it a nightmare ?'
            ])
            // ->add('tags', ChoiceType::class, [
            //         "multiple" => true
            //     ])
            ->add('submit', SubmitType::class, [
                'label' => 'Publish'
            ])
        ;
    }
}
