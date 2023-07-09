<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;

trait Updatable
{
    #[Column(name: 'updated_at', type: 'datetime')]
    private DateTime $updatedAt;

    #[PrePersist, PreUpdate]
    public function updateUpdatedAt(): void
    {
        $this->setUpdatedAt(new DateTime('now'));
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
