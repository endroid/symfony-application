<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State\Manager;

use Endroid\State\Storage\StorageInterface;
use Endroid\State\UuidGenerator\UuidGeneratorInterface;

class Manager
{
    /**
     * @var UuidGeneratorInterface
     */
    protected $uuidGenerator;

    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     * @var State[]
     */
    protected $states;

    /**
     * @var Delta[]
     */
    protected $deltas;

    /**
     * Creates a new instance.
     *
     * @param StorageInterface       $storage
     * @param UuidGeneratorInterface $uuidGenerator
     */
    public function __construct(StorageInterface $storage, UuidGeneratorInterface $uuidGenerator)
    {
        $this->storage = $storage;
        $this->uuidGenerator = $uuidGenerator;
    }

    /**
     * @param State $state
     */
    public function addState(State $state)
    {
        $this->states[$state->name] = $state;
    }

    public function getState($name)
    {
    }

    /**
     * Creates an entity.
     *
     * @param $entity
     */
    public function add($entity)
    {
        $delta = new Delta($this->uuidGenerator->generate(), Delta::TYPE_ADD, $entity);
        $this->deltas[] = $delta;
    }

    /**
     * Changes an entity's properties.
     *
     * @param $entity
     * @param $properties
     */
    public function change($entity, $properties)
    {
        $delta = new Delta($this->uuidGenerator->generate(), Delta::TYPE_CHANGE, $entity);
        $this->deltas[] = $delta;
    }

    /**
     * Deletes an entity.
     *
     * @param $entity
     */
    public function delete($entity)
    {
        $delta = new Delta($this->uuidGenerator->generate(), Delta::TYPE_REMOVE, $entity);
        $this->deltas[] = $delta;
    }

    /**
     * Saves all deltas.
     */
    public function save()
    {
        $this->storage->save($this->deltas);
    }
}
