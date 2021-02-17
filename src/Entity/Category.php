<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\ManyToOne(targetEntity=Schema::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $schema;

    /**
     * @ORM\OneToMany(targetEntity=Seat::class, mappedBy="category", orphanRemoval=true)
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
    public function setLabel($label): self
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
            $seat->setCategory($this);
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
            if ($seat->getCategory() === $this) {
                $seat->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @param Group $group
     * @return $this
     */
    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setCategory($this);
        }

        return $this;
    }

    /**
     * @param Group $group
     * @return $this
     */
    public function removeGroup(Group $group): self
    {
        if ($this->seats->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getCategory() === $this) {
                $group->setCategory(null);
            }
        }

        return $this;
    }
}
