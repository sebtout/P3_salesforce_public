<?php

namespace App\Controller;

use App\Entity\Commentary;
use App\Form\CommentaryType;
use App\Repository\CommentaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commentary', name: 'app_commentary_')]
class CommentaryController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CommentaryRepository $commentaryRepository): Response
    {
        return $this->render('commentary/index.html.twig', [
            'commentaries' => $commentaryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        CommentaryRepository $commentaryRepository
    ): Response {
        $commentary = new Commentary();
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaryRepository->save($commentary, true);

            return $this->redirectToRoute('app_commentary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary/new.html.twig', [
            'commentary' => $commentary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Commentary $commentary): Response
    {
        return $this->render('commentary/show.html.twig', [
            'commentary' => $commentary,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Commentary $commentary,
        CommentaryRepository $commentaryRepository
    ): Response {
        $form = $this->createForm(CommentaryType::class, $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaryRepository->save($commentary, true);

            return $this->redirectToRoute('app_commentary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commentary/edit.html.twig', [
            'commentary' => $commentary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Commentary $commentary,
        CommentaryRepository $commentaryRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $commentary->getId(), $request->request->get('_token'))) {
            $commentaryRepository->remove($commentary, true);
        }

        return $this->redirectToRoute('app_commentary_index', [], Response::HTTP_SEE_OTHER);
    }
}
