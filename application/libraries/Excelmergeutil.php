<?php

require "PHPExcel.php";
class Excelmergeutil extends PHPExcel
{
    public $currentRow = 3;
    public $currentColumn = 'A';

    public function __construct()
    {
        parent::__construct();
        $style = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
		);
		$this->setActiveSheetIndex(0)->getDefaultStyle()->applyFromArray($style);
    }

    public function setHeader($header)
    {
        $currentColumn = 'A';
        foreach ($header as $key => $value) {
            if (is_numeric($key)) {
                $this->getActiveSheet()->mergeCells("{$currentColumn}1:{$currentColumn}2");
                $this->getActiveSheet()->setCellValue("{$currentColumn}1", $value);
                $currentColumn = $this->nextColumn($currentColumn);
            } else {
                $count = count($value);
                $mergeCells = $currentColumn.'1:';
                $this->getActiveSheet()->setCellValue("{$currentColumn}1", $key);
                for ($i = 0; $i < $count; $i++) {
                    $this->getActiveSheet()->setCellValue("{$currentColumn}2", $value[$i]);
                    $lastColumn = $currentColumn;
                    $currentColumn = $this->nextColumn($currentColumn);
                }
                $this->getActiveSheet()->mergeCells($mergeCells.$lastColumn.'1');
            }
        }
    }

    public function nextColumn($currentColumn)
    {
        $len = strlen($currentColumn);
        if ($currentColumn{$len-1}=='Z') {
            if ($len == 1) {
                return 'AA';
            }
            else {
                return chr(ord($currentColumn{0})+1).'A';
            }
        }
        return substr($currentColumn, 0, $len-1).chr(ord($currentColumn{$len-1})+1);
    }



    public function addItem($data, $keys, $map)
    {
        $mapKeys = array_keys($map);
        foreach ($keys as $key => $subkeys) {
            if (is_numeric($key)) {
                $this->getActiveSheet()->mergeCells("{$this->currentColumn}{$this->currentRow}:{$this->currentColumn}{$this->lastRow}");
                if (in_array($subkeys, $mapKeys)) {
                    $this->getActiveSheet()->setCellValue("{$this->currentColumn}{$this->currentRow}", $map[$subkeys]($data));
                } else {
                    $this->getActiveSheet()->setCellValue("{$this->currentColumn}{$this->currentRow}", $data[$subkeys]);
                }
                $this->currentColumn = $this->nextColumn($this->currentColumn);
            } else {
                $count = count($data[$key]);
                $count = $count == 0 ? 1 : $count;
                $rowspan = ($this->lastRow+1-$this->currentRow)/$count;
                $currentColumn = $this->currentColumn;
                foreach ($subkeys as $subkey) {
                    $currentRow = $this->currentRow;
                    foreach ($data[$key] as $items) {
                        $this->getActiveSheet()->mergeCells("{$currentColumn}{$currentRow}:{$currentColumn}".($currentRow+$rowspan-1));
                        if (in_array($subkey, $mapKeys)) {
                            $this->getActiveSheet()->setCellValue("{$currentColumn}{$currentRow}", $map[$subkey]($items));
                        } else {
                            $this->getActiveSheet()->setCellValue("{$currentColumn}{$currentRow}", $items[$subkey]);
                        }
                        $currentRow = $currentRow+$rowspan;
                    }
                    $currentColumn = $this->nextColumn($currentColumn);

                }
                $this->currentColumn = $currentColumn;


            }
        }
    }


    public function LCM($a, $b)
    {
        $i = $a;
        $j = $b;
        while ($b <> 0) {
            $p = $a % $b;
            $a = $b;
            $b = $p;
        }
        return $i * $j / $a;
    }
}
