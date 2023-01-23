<?php

namespace App\Controller;

use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThreadController extends AbstractController
{
    #[Route('/thread', name: 'app_thread')]
    public function index(IdeaRepository $ideaRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        return $this->render('thread/index.html.twig', [
            'ideas' => $ideaRepository->thread($user),
        ]);
    }
}
