<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comment;

class ThreadController extends AbstractController
{
    #[Route('/thread', name: 'app_thread')]
    public function index(CommentRepository $commentRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $comments = $commentRepository->thread($user);

        return $this->render('thread/index.html.twig', [
            'comments' => $comments

        ]);
    }
}
