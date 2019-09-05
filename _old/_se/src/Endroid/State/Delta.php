<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State;

class Delta
{
    const TYPE_ADD = 'add';
    const TYPE_CHANGE = 'change';
    const TYPE_REMOVE = 'remove';

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    public $processed = false;

    /**
     * Creates a new instance.
     *
     * @param string $uuid
     * @param string $type
     */
    public function __construct($uuid, $type)
    {
        $this->uuid = $uuid;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
