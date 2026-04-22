<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * UserController
 * 
 * Handles user management (admin only)
 */
#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * List all users (admin only)
     */
    #[Route('', name: 'app_user_list', methods: ['GET'])]
    public function list(UserRepository $userRepository): Response
    {
        $this->checkAuthAdmin();

        $users = $userRepository->findAllOrdered();

        return $this->render('user/list.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * Show new user form (admin only)
     */
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthAdmin();

        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['is_edit' => false]);
        $form->handleRequest($request);

        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if username already exists
            if ($userRepository->usernameExists($user->getUsername())) {
                $errors[] = 'Username already exists.';
            } else {
                // Hash password
                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                );
                $user->setPassword($hashedPassword);

                // Set audit fields
                $user->setCreatedBy($this->getSession()->get('user_id'));
                $user->setUpdatedBy($this->getSession()->get('user_id'));

                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'User created successfully!');
                return $this->redirectToRoute('app_user_list');
            }
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * Edit user (admin only)
     */
    #[Route('/{userId}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        int $userId,
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthAdmin();

        $user = $userRepository->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $form = $this->createForm(UserType::class, $user, ['is_edit' => true]);
        $form->handleRequest($request);

        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('password')->getData();

            if (!empty($newPassword)) {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

            $user->setUpdatedBy($this->getSession()->get('user_id'));
            $em->flush();

            $this->addFlash('success', 'User updated successfully!');
            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
            'errors' => $errors
        ]);
    }

    /**
     * Delete user (admin only)
     */
    #[Route('/{userId}/delete', name: 'app_user_delete', methods: ['POST'])]
    public function delete(
        int $userId,
        UserRepository $userRepository,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthAdmin();

        // Prevent admin from deleting themselves
        if ($userId === $this->getSession()->get('user_id')) {
            $this->addFlash('error', 'You cannot delete your own account!');
            return $this->redirectToRoute('app_user_list');
        }

        $user = $userRepository->find($userId);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'User deleted successfully!');
        return $this->redirectToRoute('app_user_list');
    }

    private function checkAuthAdmin(): void
    {
        $session = $this->container->get('session');
        if (!$session->get('user_id')) {
            throw $this->createAccessDeniedException('You must be logged in');
        }

        $accountType = $session->get('account_type');
        if ($accountType !== 'admin') {
            throw $this->createAccessDeniedException('You do not have permission to access this page');
        }
    }

    private function getSession()
    {
        return $this->container->get('session');
    }
}
