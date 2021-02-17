<?php

namespace App\Entity;

use App\Form\Type\CurrencyTypeEnum;
use App\Form\Type\StatusType;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SeatStatusRepository::class)
 */
class SeatStatus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $holdToken;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="seatStatuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity=Seat::class, inversedBy="seatStatuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seat;

    public function __construct()
    {
        $this->date = new \DateTime('now');
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return $this
     */
    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return $this
     */
    public function setStatus(?string $status): self
    {
        if (!in_array($status, StatusType::getAvailableStatus())) {
            throw new \InvalidArgumentException("Invalid status");
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getHoldToken(): ?string
    {
        return $this->holdToken;
    }

    /**
     * @param string $holdToken
     * @return $this
     */
    public function setHoldToken(string $holdToken): self
    {
        $this->holdToken = $holdToken;

        return $this;
    }

    /**
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * @param Event|null $event
     * @return $this
     */
    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Seat|null
     */
    public function getSeat(): ?Seat
    {
        return $this->seat;
    }

    /**
     * @param Seat|null $seat
     * @return $this
     */
    public function setSeat(?Seat $seat): self
    {
        $this->seat = $seat;

        return $this;
    }
}
