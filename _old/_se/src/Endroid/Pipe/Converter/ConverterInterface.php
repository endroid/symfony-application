<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Pipe\Converter;

use Endroid\Pipe\Payload;

interface ConverterInterface
{
    /**
     * Returns the supported conversions.
     *
     * @return array
     */
    public function getConversions();

    /**
     * Converts the current payload to the requested output type.
     *
     * @param Payload $payload
     * @param string  $outputType
     *
     * @return Payload
     */
    public function convert(Payload $payload, $outputType);
}
