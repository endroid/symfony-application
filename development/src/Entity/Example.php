<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ApiResource
 *
 * @ORM\Entity
 * @ORM\Table(name="example")
 */
class Example
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    public function __construct(string $id, string $name)
    {
        $this->id = Uuid::fromString($id);
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
