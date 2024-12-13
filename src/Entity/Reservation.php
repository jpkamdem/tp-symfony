<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[Assert\Callback('validateTimeSlot')]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;


    #[Assert\Regex(
        pattern: '/^([01]\d|2[0-3]):[0-5]\d-([01]\d|2[0-3]):[0-5]\d$/',
        message: 'La plage horaire doit être au format HH:mm-HH:mm (exemple : 18:00-20:00).'
    )]
    #[ORM\Column(type: 'string', length: 20)]
    private ?string $timeSlot;

    #[ORM\Column(length: 255)]
    private ?string $eventName = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $relations = null;

    #[ORM\ManyToOne(inversedBy: 'relations')]
    private ?User $user_reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTimeSlot(): string
    {
        return $this->timeSlot;
    }

    public function setTimeSlot(array $timeSlot): static
    {
        $this->timeSlot = $timeSlot;

        return $this;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): static
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getRelations(): ?User
    {
        return $this->relations;
    }

    public function setRelations(?User $relations): static
    {
        $this->relations = $relations;

        return $this;
    }

    public function getUserReservation(): ?User
    {
        return $this->user_reservation;
    }

    public function setUserReservation(?User $user_reservation): static
    {
        $this->user_reservation = $user_reservation;

        return $this;
    }

    public function validateTimeSlot(ExecutionContextInterface $context): void
    {
        $parts = explode('-', $this->timeSlot);

        if (count($parts) !== 2) {
            $context->buildViolation('Format de la plage horaire incorrect.')
                ->atPath('timeSlot')
                ->addViolation();
            return;
        }

        [$start, $end] = $parts;
        $startTime = \DateTime::createFromFormat('H:i', $start);
        $endTime = \DateTime::createFromFormat('H:i', $end);

        if (!$startTime || !$endTime || $startTime >= $endTime) {
            $context->buildViolation('L\'heure de début doit être antérieure à l\'heure de fin.')
                ->atPath('timeSlot')
                ->addViolation();
        }
    }
}
