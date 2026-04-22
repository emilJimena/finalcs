<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * PasswordController
 * 
 * Handles password management
 */
#[Route('/password')]
class PasswordController extends AbstractController
{
    /**
     * Change password page
     */
    #[Route('/change', name: 'app_password_change', methods: ['GET', 'POST'])]
    public function change(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {
        $session = $this->container->get('session');

        // Check if user is logged in
        if (!$session->get('user_id')) {
            return $this->redirectToRoute('app_login');
        }

        $userId = $session->get('user_id');
        $user = $userRepository->find($userId);

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $errors = [];
        $success = false;

        if ($request->isMethod('POST')) {
            $currentPassword = trim($request->request->get('currentPassword', ''));
            $newPassword = trim($request->request->get('newPassword', ''));
            $confirmPassword = trim($request->request->get('confirmPassword', ''));

            // Validation
            if (empty($currentPassword)) {
                $errors[] = 'Current password is required.';
            } elseif (!$passwordHasher->isPasswordValid($user, $currentPassword)) {
                $errors[] = 'Current password is incorrect.';
            }

            if (empty($newPassword)) {
                $errors[] = 'New password is required.';
            } elseif (strlen($newPassword) < 6) {
                $errors[] = 'New password must be at least 6 characters.';
            }

            if (empty($confirmPassword)) {
                $errors[] = 'Password confirmation is required.';
            } elseif ($newPassword !== $confirmPassword) {
                $errors[] = 'Passwords do not match.';
            }

            if (empty($errors)) {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                $user->setUpdatedBy($userId);

                $em->flush();

                $success = true;
                $this->addFlash('success', 'Password changed successfully!');
            }
        }

        return $this->render('password/change.html.twig', [
            'errors' => $errors,
            'success' => $success
        ]);
    }

    private function getSession()
    {
        return $this->container->get('session');
    }
}
