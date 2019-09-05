<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Pipe;

class Payload
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $options;

    /**
     * Creates a new instance.
     *
     * @param mixed  $data
     * @param string $type
     * @param array  $options
     */
    public function __construct($data, $type, array $options = [])
    {
        $this->data = $data;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * Returns the data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Returns the type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
