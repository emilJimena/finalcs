<?php

namespace App\Controller;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SubjectController
 * 
 * Handles subject management
 */
#[Route('/subject')]
class SubjectController extends AbstractController
{
    /**
     * List all subjects
     */
    #[Route('', name: 'app_subject_list', methods: ['GET'])]
    public function list(SubjectRepository $subjectRepository): Response
    {
        $this->checkAuth();

        $subjects = $subjectRepository->findAllOrdered();

        return $this->render('subject/list.html.twig', [
            'subjects' => $subjects
        ]);
    }

    /**
     * Show new subject form
     */
    #[Route('/new', name: 'app_subject_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        SubjectRepository $subjectRepository,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthStaff();

        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if code already exists
            if ($subjectRepository->codeExists($subject->getCode())) {
                $errors[] = 'Subject code already exists.';
            } else {
                $em->persist($subject);
                $em->flush();

                $this->addFlash('success', 'Subject created successfully!');
                return $this->redirectToRoute('app_subject_list');
            }
        }

        return $this->render('subject/new.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * Edit subject
     */
    #[Route('/{subjectId}/edit', name: 'app_subject_edit', methods: ['GET', 'POST'])]
    public function edit(
        int $subjectId,
        Request $request,
        SubjectRepository $subjectRepository,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthStaff();

        $subject = $subjectRepository->find($subjectId);

        if (!$subject) {
            throw $this->createNotFoundException('Subject not found');
        }

        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Check if code already exists (excluding current subject)
            if ($subjectRepository->codeExists($subject->getCode(), $subjectId)) {
                $errors[] = 'Subject code already exists.';
            } else {
                $em->flush();

                $this->addFlash('success', 'Subject updated successfully!');
                return $this->redirectToRoute('app_subject_list');
            }
        }

        return $this->render('subject/edit.html.twig', [
            'form' => $form->createView(),
            'subject' => $subject,
            'errors' => $errors
        ]);
    }

    /**
     * Delete subject
     */
    #[Route('/{subjectId}/delete', name: 'app_subject_delete', methods: ['POST'])]
    public function delete(
        int $subjectId,
        SubjectRepository $subjectRepository,
        EntityManagerInterface $em
    ): Response {
        $this->checkAuthStaff();

        $subject = $subjectRepository->find($subjectId);

        if (!$subject) {
            throw $this->createNotFoundException('Subject not found');
        }

        $em->remove($subject);
        $em->flush();

        $this->addFlash('success', 'Subject deleted successfully!');
        return $this->redirectToRoute('app_subject_list');
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
