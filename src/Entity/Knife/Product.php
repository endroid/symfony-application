<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Entity\Knife;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Knife\Service", cascade={"persist"})
     */
    protected $service;

    /**
     * @ORM\Column(type="array")
     */
    protected $fieldValues;

    public function __construct()
    {
        $this->fieldValues = [];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getFieldValues()
    {
        return $this->fieldValues;
    }

    public function __get($name)
    {
        if (!isset($this->fieldValues[$name])) {
            return null;
        }

        return $this->fieldValues[$name];
    }

    public function __set($name, $value)
    {
        $this->fieldValues[$name] = $value;
    }

    public function __toString()
    {
        return (string) $this->service;
    }
}
