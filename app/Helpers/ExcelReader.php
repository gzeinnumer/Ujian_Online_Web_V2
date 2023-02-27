<?php

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelReader
{
	/** @var \PhpOffice\PhpSpreadsheet\Reader\Xlsx */
	public $reader;

	/** @var \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet[] */
	public $sheets;

	public function __construct()
	{
		$this->reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$this->reader->setReadDataOnly(true);
	}

	public function read_xlsx($file)
	{
		$spreadsheet = $this->reader->load($file);
		$this->sheets = $spreadsheet->getAllSheets();
	}

	/**
	 * @param \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet
	 * @param integer $location
	 * @return mixed
	 */
	private function _get_cell_value($sheet, $location)
	{
		$value = $sheet->getCell($location)->getCalculatedValue();
		return $value == null ? '' : $value;
	}

	public function get_cell_value($sheet_index, $location)
	{
		if (isset($this->sheets[$sheet_index])) {
			return trim($this->_get_cell_value($this->sheets[$sheet_index], $location));
		}
		return '';
	}

	public function get_cells_value($sheet_index, $locations)
	{
		$values = [];
		foreach ($locations as $key => $location) {
			$values[$key] = $this->get_cell_value($sheet_index, $location);
		}
		return $values;
	}

	public function get_cells_flag_value($sheet_index, $locations)
	{
		$data = $this->get_cells_value($sheet_index, $locations);
		$result = '';
		foreach ($data as $key => $value) {
			if ($value) {
				$result = $key;
				break;
			}
		}
		return $result;
	}

	public function get_row_count($sheet_index)
	{
		if (isset($this->sheets[$sheet_index])) {
			return $this->sheets[$sheet_index]->getHighestRow('A');
		}
		return 0;
	}
}
