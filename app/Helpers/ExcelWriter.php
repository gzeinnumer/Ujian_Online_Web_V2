<?php

namespace App;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ExcelWriter
{
	public function __construct()
	{ }

	public function write_excel($args, $filename = 'export.xlsx', $download = true)
	{
		$args = array_merge([
			'header' => [],
			'header_style' => [],
			'column_width' => [],
			'rows' => [],
			'rows_style' => [],
			'rows_height' => [],
			'sheet_title' => 'Sheet 1',
		], $args);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// fill header
		foreach ($args['header'] as $column => $value) {
			$coor = $column . 1;
			$sheet->setCellValue($coor, $value);
			$sheet->getStyle($coor)
				->applyFromArray($args['header_style']);
		}

		// fill row data
		foreach ($args['rows'] as $row => $data) {
			foreach ($data as $column => $value) {
				$coor = $column . ($row + 2);
				$sheet->setCellValue($coor, $value);
			}
		}

		// apply rows style
		foreach ($args['rows_style'] as $key => $style) {
			$coor = sprintf('%s%d:%s%d', $key, 2, $key, count($args['rows']) + 1);
			$sheet->getStyle($coor)->applyFromArray($style);
		}

		// apply column width
		foreach ($args['column_width'] as $column => $width) {
			$sheet->getColumnDimension($column)->setWidth($width);
		}

		// apply row height
		foreach ($args['rows_height'] as $row => $height) {
			$sheet->getRowDimension($row)->setRowHeight($height);
		}

		$sheet->setTitle($args['sheet_title']);
		$sheet->setSelectedCell('A' . (count($args['rows']) + 2));

		$writer = new Xlsx($spreadsheet);
		if ($download) {
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="' . $filename . '"');
			header('Cache-Control: max-age=0');
			$writer->save('php://output');
		} else {
			$writer->save($filename);
		}
		exit;
	}
}
