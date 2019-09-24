<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Traits;

trait LifeCycleTrait
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateArchived;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateDeleted;

    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    public function setCreated(): void
    {
        $this->dateCreated = new \DateTime();
    }

    public function getDateUpdated(): \DateTime
    {
        return $this->dateUpdated;
    }

    public function setUpdated(): void
    {
        $this->dateUpdated = new \DateTime();
    }

    public function getDatePublished(): ?\DateTime
    {
        return $this->datePublished;
    }

    public function isPublished(): bool
    {
        return $this->datePublished instanceof \DateTime;
    }

    public function setPublished(bool $published = true): void
    {
        if ($published && $this->datePublished instanceof \DateTime) {
            return;
        }

        $this->datePublished = $published ? new \DateTime() : null;
    }

    public function getDateArchived(): ?\DateTime
    {
        return $this->dateArchived;
    }

    public function isArchived(): bool
    {
        return $this->dateArchived instanceof \DateTime;
    }

    public function setArchived(bool $archived = true): void
    {
        if ($archived && $this->dateArchived instanceof \DateTime) {
            return;
        }

        $this->dateArchived = $archived ? new \DateTime() : null;
    }

    public function getDateDeleted(): ?\DateTime
    {
        return $this->dateDeleted;
    }

    public function isDeleted(): bool
    {
        return $this->dateDeleted instanceof \DateTime;
    }

    public function setDeleted(bool $deleted = true): void
    {
        if ($deleted && $this->dateDeleted instanceof \DateTime) {
            return;
        }

        $this->dateDeleted = $deleted ? new \DateTime() : null;
    }
}
