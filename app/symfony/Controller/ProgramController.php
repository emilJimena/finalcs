<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ProgramController
 * 
 * Handles program management
 */
#[Route('/program')]
class ProgramController extends AbstractController
{
    /**
     * List all programs
     */
    #[Route('', name: 'app_program_list', methods: ['GET'])]
    public function list(ProgramRepository $programRepository): Response
    {
        $this->checkAuth();

        $programs = $programRepository->findAllOrdered();

        return $this->render('program/list.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * Show new program form
     */
    #[Route('/new', name: 'app_program_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ProgramRepository $programRepository,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthStaff();

        $program = new Program();
        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if code already exists
            if ($programRepository->codeExists($program->getCode())) {
                $errors[] = 'Program code already exists.';
            } else {
                $em->persist($program);
                $em->flush();

                $this->addFlash('success', 'Program created successfully!');
                return $this->redirectToRoute('app_program_list');
            }
        }

        return $this->render('program/new.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * Edit program
     */
    #[Route('/{programId}/edit', name: 'app_program_edit', methods: ['GET', 'POST'])]
    public function edit(
        int $programId,
        Request $request,
        ProgramRepository $programRepository,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthStaff();

        $program = $programRepository->find($programId);

        if (!$program) {
            throw $this->createNotFoundException('Program not found');
        }

        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if code already exists (excluding current program)
            if ($programRepository->codeExists($program->getCode(), $programId)) {
                $errors[] = 'Program code already exists.';
            } else {
                $em->flush();

                $this->addFlash('success', 'Program updated successfully!');
                return $this->redirectToRoute('app_program_list');
            }
        }

        return $this->render('program/edit.html.twig', [
            'form' => $form->createView(),
            'program' => $program,
            'errors' => $errors
        ]);
    }

    /**
     * Delete program
     */
    #[Route('/{programId}/delete', name: 'app_program_delete', methods: ['POST'])]
    public function delete(
        int $programId,
        ProgramRepository $programRepository,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthStaff();

        $program = $programRepository->find($programId);

        if (!$program) {
            throw $this->createNotFoundException('Program not found');
        }

        $em->remove($program);
        $em->flush();

        $this->addFlash('success', 'Program deleted successfully!');
        return $this->redirectToRoute('app_program_list');
    }

    private function checkAuth(): void
    {
        $session = $this->container->get('session');
        if (!$session->get('user_id')) {
            throw $this->createAccessDeniedException('You must be logged in');
        }
    }

    private function checkAuthStaff(): void
    {
        $session = $this->container->get('session');
        if (!$session->get('user_id')) {
            throw $this->createAccessDeniedException('You must be logged in');
        }

        $accountType = $session->get('account_type');
        if (!in_array($accountType, ['admin', 'staff'])) {
            throw $this->createAccessDeniedException('You do not have permission to access this page');
        }
    }
}
