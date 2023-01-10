<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserPictureType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/{id}/profile', name: 'app_user_profile', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function updateProfilePicture(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserPictureType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/profile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
