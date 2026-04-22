<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\SubjectRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * HomeController
 * 
 * Handles home page and dashboard
 */
#[Route('')]
class HomeController extends AbstractController
{
    /**
     * Show home page / dashboard
     */
    #[Route('/', name: 'app_home', methods: ['GET'])]
    #[Route('/home', name: 'app_home_alt', methods: ['GET'])]
    public function index(
        SubjectRepository $subjectRepository,
        ProgramRepository $programRepository
    ): Response {
        $session = $this->getSession();

        // Check if user is logged in
        if (!$session->get('user_id')) {
            return $this->redirectToRoute('app_login');
        }

        $userId = $session->get('user_id');
        $username = $session->get('username');
        $accountType = $session->get('account_type');

        $subjectCount = count($subjectRepository->findAll());
        $programCount = count($programRepository->findAll());

        return $this->render('home/index.html.twig', [
            'username' => $username,
            'accountType' => $accountType,
            'subjectCount' => $subjectCount,
            'programCount' => $programCount,
            'isAdmin' => $accountType === 'admin',
            'isStaff' => $accountType === 'staff'
        ]);
    }

    private function getSession()
    {
        return $this->container->get('session');
    }
}
