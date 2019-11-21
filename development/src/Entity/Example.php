<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ApiResource(attributes={"order"={"name": "ASC"}})
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
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct(string $id, string $name)
    {
        $this->id = Uuid::fromString($id);
        $this->name = $name;
    }

    public function getId(): string
    {
        return strval($this->id);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
