<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * AuthController
 * 
 * Handles authentication operations
 */
#[Route('')]
class AuthController extends AbstractController
{
    /**
     * Show login form
     */
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response {
        // If already logged in, redirect to home
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $errors = [];
        $username = '';

        if ($request->isMethod('POST')) {
            $username = trim($request->request->get('username', ''));
            $password = trim($request->request->get('password', ''));

            // Validation
            if (empty($username)) {
                $errors[] = 'Username is required.';
            }
            if (empty($password)) {
                $errors[] = 'Password is required.';
            }

            // Check credentials
            if (empty($errors)) {
                $user = $userRepository->findByUsername($username);

                if ($user && $passwordHasher->isPasswordValid($user, $password)) {
                    $this->getSession()->set('user_id', $user->getId());
                    $this->getSession()->set('username', $user->getUsername());
                    $this->getSession()->set('account_type', $user->getAccountType());

                    return $this->redirectToRoute('app_home');
                } else {
                    $errors[] = 'Invalid username or password.';
                }
            }
        }

        return $this->render('auth/login.html.twig', [
            'errors' => $errors,
            'username' => $username
        ]);
    }

    /**
     * Handle logout
     */
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(Request $request): Response
    {
        $session = $request->getSession();
        $session->invalidate();

        return $this->redirectToRoute('app_login');
    }

    private function getSession()
    {
        return $this->container->get('session');
    }
}
