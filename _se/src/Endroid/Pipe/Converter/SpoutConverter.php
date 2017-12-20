<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Pipe\Converter;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Endroid\Pipe\Exception\UnsupportedExtensionException;
use Endroid\Pipe\Payload;

class SpoutConverter extends AbstractConverter
{
    /**
     * {@inheritdoc}
     */
    protected $conversions = [
        'file|spreadsheet' => [
            'array',
        ],
    ];

    /**
     * @var array
     */
    protected $extensionTypes = [
        'csv' => Type::CSV,
        'xls' => Type::XLSX,
        'xlsx' => Type::XLSX,
    ];

    /**
     * {@inheritdoc}
     */
    public function convert(Payload $payload, $outputType)
    {
        $filename = $payload->getData();
        $type = $this->getType($filename);
        $reader = ReaderFactory::create($type);
        $reader->open($filename);

        $sheets = [];
        foreach ($reader->getSheetIterator() as $sheet) {
            $columnNames = [];
            $sheets[$sheet->getName()] = [];
            foreach ($sheet->getRowIterator() as $rowNumber => $row) {
                if (count($columnNames) == 0) {
                    if ($row[0] == '') {
                        continue;
                    } else {
                        $columnNames = $row;
                    }
                } else {
                    $sheets[$sheet->getName()][] = array_combine($columnNames, $row);
                }
            }
        }

        return new Payload($sheets, 'array');
    }

    /**
     * Returns the file type.
     *
     * @param $filename
     *
     * @return mixed
     *
     * @throws UnsupportedExtensionException
     */
    protected function getType($filename)
    {
        $extension = strtolower(substr(strrchr($filename, '.'), 1));

        if (!isset($this->extensionTypes[$extension])) {
            throw new UnsupportedExtensionException();
        }

        return $this->extensionTypes[$extension];
    }
}
