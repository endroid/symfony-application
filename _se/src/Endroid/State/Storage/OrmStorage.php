<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State\Storage;

use Doctrine\ORM\EntityManager;
use Endroid\State\Delta;

class OrmStorage implements StorageInterface
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * Creates a new instance.
     *
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $deltas)
    {
        foreach ($deltas as $delta) {
            $this->manager->persist($delta);
        }

        $this->manager->flush();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load()
    {
        $queryBuilder = $this->manager->createQueryBuilder();
        $queryBuilder
            ->select('delta')
            ->from('Endroid\State\Delta', 'delta')
            ->where('delta.processed = 0');

        $deltas = $queryBuilder->getQuery()->getResult();

        return $deltas;
    }

    /**
     * {@inheritdoc}
     */
    public function markDeltaAsProcessed(Delta $delta)
    {
        $delta->processed = true;
        $this->manager->persist($delta);
        $this->manager->flush();
    }
}
