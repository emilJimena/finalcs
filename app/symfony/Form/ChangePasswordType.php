<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;

/**
 * ChangePasswordType Form
 */
class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Current Password',
                'constraints' => [
                    new NotBlank(['message' => 'Current password is required'])
                ],
                'attr' => [
                    'placeholder' => 'Enter your current password',
                    'class' => 'form-control'
                ]
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'New Password',
                    'constraints' => [
                        new NotBlank(['message' => 'New password is required']),
                        new Length(['min' => 6, 'minMessage' => 'Password must be at least 6 characters'])
                    ],
                    'attr' => [
                        'placeholder' => 'Enter new password',
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm New Password',
                    'constraints' => [
                        new NotBlank(['message' => 'Password confirmation is required'])
                    ],
                    'attr' => [
                        'placeholder' => 'Confirm new password',
                        'class' => 'form-control'
                    ]
                ],
                'invalid_message' => 'Passwords must match',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Change Password',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
