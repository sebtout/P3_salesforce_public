<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ThreadController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/thread', name: 'app_thread')]
    public function index(CommentRepository $commentRepository, IdeaRepository $ideaRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $comments = $commentRepository->thread($user);
        $ideas = [];
        foreach ($comments as $comment) {
            $idea = $comment->getIdea();
            $ideas[] = $idea;
        }

        $ideas = array_unique($ideas);

        return $this->render('thread/index.html.twig', [
            'comments' => $comments,
            'ideas' => $ideas
        ]);
    }
}
