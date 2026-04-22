<?php

namespace App\Form;

use App\Entity\Subject;
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
 * SubjectType Form
 */
class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'label' => 'Subject Code',
                'constraints' => [
                    new NotBlank(['message' => 'Subject code is required']),
                    new Length(['max' => 20])
                ],
                'attr' => [
                    'placeholder' => 'e.g., MATH101',
                    'class' => 'form-control'
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Subject Title',
                'constraints' => [
                    new NotBlank(['message' => 'Subject title is required']),
                    new Length(['max' => 100])
                ],
                'attr' => [
                    'placeholder' => 'e.g., Basic Mathematics',
                    'class' => 'form-control'
                ]
            ])
            ->add('unit', IntegerType::class, [
                'label' => 'Unit',
                'constraints' => [
                    new NotBlank(['message' => 'Unit is required']),
                    new Positive(['message' => 'Unit must be greater than 0'])
                ],
                'attr' => [
                    'placeholder' => 'e.g., 3',
                    'class' => 'form-control',
                    'min' => 1
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Subject',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
