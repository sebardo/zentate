<?php

namespace App\Entity;

use App\Repository\SeatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SeatRepository::class)
 */
class Seat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $label;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $displayedLabel;

    /**
     * @ORM\ManyToOne(targetEntity=Schema::class, inversedBy="seats")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $schema;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="seats")
     * @ORM\JoinColumn(nullable=true)
     */
    private $group;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="seats")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=SeatStatus::class, mappedBy="seat", orphanRemoval=true)
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
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDisplayedLabel(): ?string
    {
        return $this->displayedLabel;
    }

    /**
     * @param string|null $displayedLabel
     * @return $this
     */
    public function setDisplayedLabel(?string $displayedLabel): self
    {
        $this->displayedLabel = $displayedLabel;

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
     * @return Group|null
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }

    /**
     * @param Group|null $group
     * @return $this
     */
    public function setGroup(?Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
