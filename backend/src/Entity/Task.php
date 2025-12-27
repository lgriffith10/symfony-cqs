<?php

namespace App\Entity;

use App\Entity\Interface\AuditableInterface;
use App\Entity\Trait\AuditTrait;
use App\Enum\TaskState;
use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task implements AuditableInterface
{
    use AuditTrait;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private ?Uuid $id;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(enumType: TaskState::class)]
    private ?TaskState $State = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $ExpectedAt = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getState(): ?TaskState
    {
        return $this->State;
    }

    public function setState(TaskState $State): static
    {
        $this->State = $State;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getExpectedAt(): ?\DateTimeImmutable
    {
        return $this->ExpectedAt;
    }

    public function setExpectedAt(\DateTimeImmutable $ExpectedAt): static
    {
        $this->ExpectedAt = $ExpectedAt;

        return $this;
    }
}
