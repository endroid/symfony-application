<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\State\View;

abstract class AbstractView implements ViewInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Creates a new instance.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        if (!isset($this->data)) {
            $this->loadData();
        }

        return $this->data;
    }

    /**
     * Loads the data.
     */
    abstract protected function loadData();
}
