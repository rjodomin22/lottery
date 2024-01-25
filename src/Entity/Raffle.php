<?php

namespace App\Entity;

use App\Repository\RaffleRepository;
use App\Entity\Criteria;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaffleRepository::class)]
class Raffle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateTime = null;

    #[ORM\Column]
    private ?float $prize = null;

    #[ORM\Column]
    private ?float $pricePerTicket = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Ticket $winner = null;

    #[ORM\OneToMany(mappedBy: 'raffle_id', targetEntity: Ticket::class)]
    private Collection $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateTime(): ?\DateTimeInterface
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeInterface $dateTime): static
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getPrize(): ?float
    {
        return $this->prize;
    }

    public function setPrize(float $prize): static
    {
        $this->prize = $prize;

        return $this;
    }

    public function getPricePerTicket(): ?float
    {
        return $this->pricePerTicket;
    }

    public function setPricePerTicket(float $pricePerTicket): static
    {
        $this->pricePerTicket = $pricePerTicket;

        return $this;
    }

    public function getWinner(): ?Ticket
    {
        return $this->winner;
    }

    public function setWinner(?Ticket $winner): static
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setRaffleId($this);
        }

        return $this;
    }
    /* public function getTicketsWithNullBuyerId(): Collection
    {
        // Create a criteria to filter tickets with null buyer_id
        $criteria = Criteria::create()->where(Criteria::expr()->eq('buyer_id', null));

        // Apply the criteria to the tickets collection
        return $this->tickets->matching($criteria);
    }
 */
    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getRaffleId() === $this) {
                $ticket->setRaffleId(null);
            }
        }

        return $this;
    }
}
