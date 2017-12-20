<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Pipe\Converter;

use Endroid\Pipe\Payload;

abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @var array
     */
    protected $conversions;

    /**
     * {@inheritdoc}
     */
    public function getConversions()
    {
        return $this->conversions;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function convert(Payload $payload, $outputType);
}
