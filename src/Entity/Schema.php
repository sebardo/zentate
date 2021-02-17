<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=App\Repository\SchemaRepository::class)
 */
class Schema
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
     * @Assert\NotBlank(groups={"create"})
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $uploadedAt;

    /**
     * @ORM\OneToMany(targetEntity=Event::class, mappedBy="schema")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="schema")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Seat::class, mappedBy="schema", orphanRemoval=true)
     */
    private $seats;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->events = new ArrayCollection();
        $this->categories = new ArrayCollection();
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploadedAt;
    }

    /**
     * @param \DateTimeInterface $uploadedAt
     * @return $this
     */
    public function setUploadedAt(\DateTimeInterface $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return $this
     */
    public function addEvent(Event $event): self
    {
        if (!$this->products->contains($event)) {
            $this->events[] = $event;
            $event->setSchema($this);
        }

        return $this;
    }

    /**
     * @param Event $event
     * @return $this
     */
    public function removeEvent(Event $event): self
    {
        if ($this->products->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getSchema() === $this) {
                $event->setSchema(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setSchema($this);
        }

        return $this;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getSchema() === $this) {
                $category->setSchema(null);
            }
        }

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
            $seat->setSchema($this);
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
            if ($seat->getSchema() === $this) {
                $seat->setSchema(null);
            }
        }

        return $this;
    }
}
