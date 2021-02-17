<?php

namespace App\Entity;

use App\Form\Type\CurrencyTypeEnum;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * A product may or may not have an associated category
     * @ORM\ManyToOne(targetEntity=Schema::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $schema;

    /**
     * @ORM\OneToMany(targetEntity=SeatStatus::class, mappedBy="event", orphanRemoval=true)
     */
    private $seatStatuses;

    public function __construct()
    {
        $this->seatStatuses = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Schema|null
     */
    public function getSchema(): ?Schema
    {
        return $this->schema;
    }

    /**
     * @param Schema|null $schema
     * @return $this
     */
    public function setSchema(?Schema $schema): self
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * @return Collection|SeatStatus[]
     */
    public function getSeatStatuses(): Collection
    {
        return $this->seatStatuses;
    }

    /**
     * @param SeatStatus $seatStatuses
     * @return $this
     */
    public function addSeatStatus(SeatStatus $seatStatuses): self
    {
        if (!$this->seatStatuses->contains($seatStatuses)) {
            $this->seatStatuses[] = $seatStatuses;
            $seatStatuses->setEvent($this);
        }

        return $this;
    }

    /**
     * @param SeatStatus $seatStatuses
     * @return $this
     */
    public function removeSeatStatus(SeatStatus $seatStatuses): self
    {
        if ($this->seatStatuses->removeElement($seatStatuses)) {
            // set the owning side to null (unless already changed)
            if ($seatStatuses->getEvent() === $this) {
                $seatStatuses->setEvent(null);
            }
        }

        return $this;
    }
}
