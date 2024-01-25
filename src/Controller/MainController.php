<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Notification;
use App\Repository\RaffleRepository;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use App\Repository\NotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Request $request,RaffleRepository $raffleRepository, EntityManagerInterface $entityManager): Response
    {
        $error = $request->query->get('error');

        $user = $this->getUser();
        $raffles = $raffleRepository->findFinishedRaffles();
        foreach ($raffles as $raffle) {
            
                $tickets = $raffle->getTickets()->toArray();
                shuffle($tickets);
                $raffle->setWinner($tickets[0]);
                if ($tickets[0]->getBuyer() != null) {
                    $notification = new Notification();
                    $notification->setUser($tickets[0]->getBuyer());
                    $notification->setDateTime( new \DateTime());
                    $notification->setText("Hola " . $tickets[0]->getBuyer()->getUsername() . " has sido premiado en el sorteo " .$raffle->getName() . " y has ganado " . $raffle->getPrize());
                    $notification->setRaffleNotification($raffle);
                    $notification->setAccepted(0);
                    }
                    $entityManager->persist( $notification );
                    $entityManager->flush();
            
        }
        $notifications = [];
        if ($user) {
            $notifications = $user->getNotifications()->filter(function ($notification) {
                return $notification->getAccepted() == 0;
            });
        }
        $raffles2 = $raffleRepository->findOpensRaffles();
        return $this->render('main/index.html.twig', [
            'raffles' => $raffles2,
            'notifications' => $notifications,
            'error' => $error,
        ]);
    }
}
