<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numberTicket = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?User $buyer = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    private ?Raffle $raffle_id   = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberTicket(): ?int
    {
        return $this->numberTicket;
    }

    public function setNumberTicket(int $numberTicket): static
    {
        $this->numberTicket = $numberTicket;

        return $this;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    public function setBuyer(?User $buyer): static
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getRaffleId(): ?Raffle
    {
        return $this->raffle_id;
    }

    public function setRaffleId(?Raffle $raffle_id): static
    {
        $this->raffle_id = $raffle_id;

        return $this;
    }
}
