<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Pipe;

use Endroid\SimpleExcel\Converter\ConverterInterface;
use Endroid\SimpleExcel\Exception\UnsupportedConversionException;

class Pipe
{
    /**
     * @var ConverterInterface[]
     */
    protected $converters;

    /**
     * Creates a new instance.
     */
    public function __construct()
    {
        $this->types = [];
        $this->converters = [];
    }

    /**
     * Adds a converter.
     *
     * @param ConverterInterface $converter
     */
    public function addConverter(ConverterInterface $converter)
    {
        $this->converters[] = $converter;
    }

    /**
     * Converts the payload to the given output type.
     *
     * @param Payload $payload
     * @param string  $outputType
     *
     * @return Payload
     */
    public function convert(Payload $payload, $outputType)
    {
        $converters = $this->calculateRoute($payload->getType(), $outputType);

        foreach ($converters as $converter) {
            $payload = $converter->convert($payload, $outputType);
        }

        return $payload->getData();
    }

    /**
     * Determines the converters to use in order to complete the conversion.
     *
     * @param string $inputType
     * @param string $outputType
     * @param array  $recordedInputTypes
     *
     * @return ConverterInterface[]
     *
     * @throws UnsupportedConversionException
     */
    protected function calculateRoute($inputType, $outputType, $recordedInputTypes = [])
    {
        $recordedInputTypes[] = $inputType;
        foreach ($this->converters as $converter) {
            foreach ($converter->getConversions() as $converterInputType => $converterOutputTypes) {
                if ($converterInputType == $inputType) {
                    foreach ($converterOutputTypes as $converterOutputType) {
                        if ($converterOutputType == $outputType) {
                            return [$converter];
                        } elseif (!in_array($converterOutputType, $recordedInputTypes)) {
                            $converters = $this->calculateRoute($converterOutputType, $outputType, $recordedInputTypes);
                            if (count($converters) > 0) {
                                array_unshift($converters, $converter);

                                return $converters;
                            }
                        }
                    }
                }
            }
        }

        if (count($recordedInputTypes) == 1) {
            throw new UnsupportedConversionException();
        }

        return [];
    }
}
