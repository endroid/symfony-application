<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\Pipe\Converter;

use Endroid\Pipe\Payload;
use PHPExcel;

class PhpExcelConverter extends AbstractConverter
{
    /**
     * {@inheritdoc}
     */
    protected $conversions = [
        'array' => [
            'php_excel',
        ],
        'file|spreadsheet' => [
            'php_excel',
        ],
        'php_excel' => [
            'array',
            'file|spreadsheet',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function convert(Payload $payload, $outputType)
    {
        dump($payload);

        $sheets = $payload->getData();

        $excel = new PHPExcel();
        $excel->removeSheetByIndex(0);

        foreach ($sheets as $sheetName => $sheet) {
            $excelSheet = $excel->createSheet();
            $excelSheet->setTitle($sheetName);

            // When no content is available leave sheet empty
            if (count($sheet) == 0) {
                continue;
            }

            // Set column headers
            $headers = array_keys($sheet[0]);
            array_unshift($sheet, $headers);

            // Place values in sheet
            $rowId = 1;
            foreach ($sheet as $row) {
                $colId = ord('A');
                foreach ($row as $value) {
                    if ($value === null) {
                        $value = 'NULL';
                    }
                    $excelSheet->setCellValue(chr($colId).$rowId, $value);
                    ++$colId;
                }
                ++$rowId;
            }
        }

        return new Payload($excel, 'php_excel');
    }
}
