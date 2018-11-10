<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Message\Example\CreateExample;
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

    public static function createFromMessage(CreateExample $createExample)
    {
        $self = new self(
            $createExample->getId(),
            $createExample->getName()
        );

        return $self;
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
