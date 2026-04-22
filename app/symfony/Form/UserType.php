<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * UserType Form
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'] ?? false;

        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
                'constraints' => [
                    new NotBlank(['message' => 'Username is required']),
                    new Length(['min' => 3, 'max' => 50])
                ],
                'attr' => [
                    'placeholder' => 'Enter username',
                    'class' => 'form-control',
                    'readonly' => $isEdit
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => $isEdit ? 'Password (leave blank to keep current)' : 'Password',
                'required' => !$isEdit,
                'constraints' => $isEdit ? [] : [
                    new NotBlank(['message' => 'Password is required']),
                    new Length(['min' => 6, 'minMessage' => 'Password must be at least 6 characters'])
                ],
                'attr' => [
                    'placeholder' => 'Enter password',
                    'class' => 'form-control'
                ]
            ])
            ->add('accountType', ChoiceType::class, [
                'label' => 'Account Type',
                'choices' => [
                    'Admin' => 'admin',
                    'Staff' => 'staff',
                    'Teacher' => 'teacher',
                    'Student' => 'student'
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('save', SubmitType::class, [
                'label' => $isEdit ? 'Update User' : 'Create User',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false
        ]);
    }
}
