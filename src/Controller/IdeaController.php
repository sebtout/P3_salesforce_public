<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use App\Entity\Idea;
use App\Entity\IdeaLike;
use App\Form\IdeaType;
use App\Form\IdeaAdminType;
use App\Form\SearchIdeaType;
use App\Repository\CommentRepository;
use App\Repository\IdeaLikeRepository;
use App\Repository\IdeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/idea', name: 'app_idea_')]
#[IsGranted('ROLE_USER')]

class IdeaController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET', 'POST'])]
    public function index(Request $request, IdeaRepository $ideaRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $form = $this->createForm(SearchIdeaType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var ClickableInterface $clikable1  */
            $clikable1 = $form->get('mostCommented');
            /** @var ClickableInterface $clikable2  */
            $clikable2 = $form->get('mostLiked');
            /** @var ClickableInterface $clikable3  */
            $clikable3 = $form->get('myLiked');
            if ($clikable1->isClicked()) {
                $ideas = $ideaRepository->findAllCommentByIdea();
            } elseif ($clikable2->isClicked()) {
                $ideas = $ideaRepository->mostLikedIdeas();
            } elseif ($clikable3->isClicked()) {
                $ideas = $ideaRepository->findAllIdeaLike($user);
            } else {
                $ideas = $ideaRepository->findAllIdeasWithAuthorAndLike();
            }
        } else {
            $ideas = $ideaRepository->findAllIdeasWithAuthorAndLike();
        }
        return $this->render('idea/index.html.twig', [
            'ideas' => $ideas,
            'form' => $form->createView(),
        ]);
    }

    #[Route('admin/list', name: 'list_idea', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]

    public function list(IdeaRepository $ideaRepository): Response
    {
        return $this->render('idea/list_idea_admin.html.twig', [
            'ideas' => $ideaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, IdeaRepository $ideaRepository,): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $idea = new Idea();
        $form = $this->createForm(IdeaType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idea->setAuthor($user);
            $idea->setStatus('in progress');
            $ideaRepository->save($idea, true);

            return $this->redirectToRoute('app_idea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('idea/new.html.twig', [
            'idea' => $idea,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET', 'POST'])]

    public function show(Idea $idea, CommentRepository $commentRepository, Request $request): Response
    {
        $id = $idea->getId();

        $idea->getComments();

        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setIdea($idea);
            $comment->setAuthor($user);
            $commentRepository->save($comment, true);

            return $this->redirectToRoute('app_idea_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('idea/show.html.twig', [
            'idea' => $idea,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(
        Request $request,
        Idea $idea,
        IdeaRepository $ideaRepository
    ): Response {
        $form = $this->createForm(IdeaAdminType::class, $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ideaRepository->save($idea, true);

            return $this->redirectToRoute('app_idea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('idea/edit.html.twig', [
            'idea' => $idea,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]

    public function delete(Request $request, Idea $idea, IdeaRepository $ideaRepository): Response
    {

        if ($this->isCsrfTokenValid('delete' . $idea->getId(), $request->request->get('_token'))) {
            $ideaRepository->remove($idea, true);
        }

        return $this->redirectToRoute('app_idea_list_idea', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Like or unlike an Idea
     * @param Idea $idea
     * @param IdeaLikeRepository $ideaLikeRepository
     * @return Response
     */

    #[Route('/likeIndex/{id}', name: 'likeIndex', methods: ['GET'])]

    public function likeIndex(Idea $idea, IdeaLikeRepository $ideaLikeRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($idea->isLikedByUser($user)) {
            $like = $ideaLikeRepository->findOneBy([
                'idea' => $idea,
                'user' => $user,
            ]);

            $ideaLikeRepository->remove($like, true);

            return $this->json([
                'isLikedByUser' => $idea->isLikedByUser($user),
                'numberOfLikes' => count($idea->getLikes())
            ]);
        }

        $like = new IdeaLike();
        $like->setIdea($idea);
        $like->setUser($user);

        $ideaLikeRepository->save($like, true);

        return $this->json([
            'isLikedByUser' => $idea->isLikedByUser($user),
            'numberOfLikes' => count($idea->getLikes())
        ]);
    }

    #[Route('/likeShow/{id}', name: 'likeShow', methods: ['GET'])]

    public function likeShow(Idea $idea, IdeaLikeRepository $ideaLikeRepository): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($idea->isLikedByUser($user)) {
            $like = $ideaLikeRepository->findOneBy([
                'idea' => $idea,
                'user' => $user,
            ]);

            $ideaLikeRepository->remove($like, true);

            return $this->redirectToRoute('app_idea_show', ['id' => $idea->getId()], Response::HTTP_SEE_OTHER);
        }

        $like = new IdeaLike();
        $like->setIdea($idea);
        $like->setUser($user);

        $ideaLikeRepository->save($like, true);

        return $this->redirectToRoute('app_idea_show', ['id' => $idea->getId()], Response::HTTP_SEE_OTHER);
    }
}
