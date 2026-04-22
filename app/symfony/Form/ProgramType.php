<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\Length;

/**
 * ProgramType Form
 */
class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Program Code',
                'constraints' => [
                    new NotBlank(['message' => 'Program code is required']),
                    new Length(['max' => 20])
                ],
                'attr' => [
                    'placeholder' => 'e.g., BS-IT',
                    'class' => 'form-control'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Program Title',
                'constraints' => [
                    new NotBlank(['message' => 'Program title is required']),
                    new Length(['max' => 100])
                ],
                'attr' => [
                    'placeholder' => 'e.g., Bachelor of Science in Information Technology',
                    'class' => 'form-control'
                ]
            ])
            ->add('years', IntegerType::class, [
                'label' => 'Years',
                'constraints' => [
                    new NotBlank(['message' => 'Years is required']),
                    new Positive(['message' => 'Years must be greater than 0'])
                ],
                'attr' => [
                    'placeholder' => 'e.g., 4',
                    'class' => 'form-control',
                    'min' => 1
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Program',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
