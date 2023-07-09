<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\PrePersist;

trait Creatable
{
    #[Column(name: 'created_at', type: 'datetime')]
    private ?DateTime $createdAt = null;

    #[PrePersist]
    public function updateCreatedAt(): void
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new DateTime('now'));
        }
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
