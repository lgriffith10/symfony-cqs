<?php

namespace App\Entity\Interface;

use App\Entity\User;

interface AuditableInterface
{
    public function setCreatedAt(\DateTimeImmutable $createdAt): self;

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self;

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self;

    public function setCreatedBy(?User $user): self;

    public function setUpdatedBy(?User $user): self;

    public function setDeletedBy(?User $user): self;
}
