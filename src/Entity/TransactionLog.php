<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TransactionLogRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionLogRepository::class)
 */
class TransactionLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="json")
     */
    private $context = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $level;

    /**
     * @ORM\Column(type="json")
     */
    private $extra = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getContext(): ?array
    {
        return $this->context;
    }

    public function setContext(array $context): self
    {
        $this->context = $context;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getExtra(): ?array
    {
        return $this->extra;
    }

    public function setExtra(array $extra): self
    {
        $this->extra = $extra;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSeat(): ?string
    {
        if (array_key_exists('seat', $this->context)) {
            return $this->context['seat'];
        }

        return null;
    }

    public function getEvent(): ?string
    {
        if (array_key_exists('event', $this->context)) {
            return $this->context['event'];
        }

        return null;
    }

    public function getSchema(): ?Document
    {
        if (array_key_exists('schema', $this->context)) {
            return $this->context['schema'];
        }

        return null;
    }

    public function getGroup(): ?Platform
    {
        if (array_key_exists('group', $this->context)) {
            return $this->context['group'];
        }

        return null;
    }

    public function getCategory(): ?string
    {
        if (array_key_exists('category', $this->context)) {
            return $this->context['category'];
        }

        return null;
    }
}
