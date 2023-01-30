<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ThreadController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
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
