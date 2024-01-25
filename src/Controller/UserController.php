<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/money', name: 'app_user_money', methods: ['GET'])]
    public function listUsersMoney(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['money' => 'DESC']);

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/totalInvested', name: 'app_user_totalInvest', methods: ['GET'])]
    public function listUsersTotalInvested(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy([], ['total_invested' => 'DESC']);

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/wins', name: 'app_user_winnerTickets', methods: ['GET'])]
    public function listUsersGetWinCounts(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAllOrderByTotalWinsDesc();

        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    
    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/ingresar', name: 'app_user_ingresar', methods: ['POST'])]
    public function ingresar(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
         $inversion = $request->request->get('moneyInvest');
        if($inversion){
            
            $user->setMoney($user->getMoney() + $inversion);
             $user->setTotalInvested($user->getTotalInvested() + $inversion);
             $entityManager->persist($user);
             $entityManager->flush();

        }
        
        return $this->redirectToRoute('app_user_show', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
