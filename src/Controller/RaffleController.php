<?php

namespace App\Controller;

use App\Entity\Raffle;
use App\Form\RaffleType;
use App\Repository\RaffleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ticket;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/raffle')]
class RaffleController extends AbstractController
{
    #[Route('/', name: 'app_raffle_index', methods: ['GET'])]
    public function index(RaffleRepository $raffleRepository): Response
    {
        return $this->render('raffle/index.html.twig', [
            'raffles' => $raffleRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_raffle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raffle = new Raffle();
        $form = $this->createForm(RaffleType::class, $raffle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             for($i = 0; $i < $form->get('numberOfTickets')->getData(); $i++){
                $ticket = new Ticket();
                $ticket->setNumberTicket($i);
                $ticket->setRaffleId($raffle);
                $entityManager->persist($ticket);
            }

            $entityManager->persist($raffle);
            $entityManager->flush();

            return $this->redirectToRoute('app_raffle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('raffle/new.html.twig', [
            'raffle' => $raffle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_raffle_show', methods: ['GET'])]
    public function show(Raffle $raffle): Response
    {
        return $this->render('raffle/show.html.twig', [
            'raffle' => $raffle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_raffle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Raffle $raffle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RaffleType::class, $raffle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_raffle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('raffle/edit.html.twig', [
            'raffle' => $raffle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_raffle_delete', methods: ['POST'])]
    public function delete(Request $request, Raffle $raffle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raffle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($raffle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_raffle_index', [], Response::HTTP_SEE_OTHER);
    }
}
