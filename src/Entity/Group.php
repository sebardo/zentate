<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="groups")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     */
    private $label;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $displayedLabel;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="groups")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Seat::class, mappedBy="group", orphanRemoval=true)
     */
    private $seats;

    public function __construct()
    {
        $this->seats = new ArrayCollection();
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
     * @return Collection|Seat[]
     */
    public function getSeats(): Collection
    {
        return $this->seats;
    }

    /**
     * @param Seat $seat
     * @return $this
     */
    public function addSeat(Seat $seat): self
    {
        if (!$this->seats->contains($seat)) {
            $this->seats[] = $seat;
            $seat->setGroup($this);
        }

        return $this;
    }

    /**
     * @param Seat $seat
     * @return $this
     */
    public function removeSeat(Seat $seat): self
    {
        if ($this->seats->removeElement($seat)) {
            // set the owning side to null (unless already changed)
            if ($seat->getGroup() === $this) {
                $seat->setGroup(null);
            }
        }

        return $this;
    }
}
