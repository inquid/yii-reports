<?php

namespace inquid\yiireports;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use yii\helpers\Html;

class ExcelHelper
{
    private $objPHPExcel;
    private $addFilters = true;
    const DEFAULT_PATH = 'files';

    /**
     * @param array $baseArray Array with the contents
     * @param array $headers Array of arrays of the headers
     * [
     * ['coordinate' => 'A1', 'title' => 'Header 1'],
     * ['coordinate' => 'B1', 'title' => 'Header 2'],
     * ['coordinate' => 'C1', 'title' => 'Header 3'],
     * ['coordinate' => 'D1', 'title' => 'Header 4'],
     * ['coordinate' => 'E1', 'title' => 'Header 5'],
     * ]
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function createExportTable($baseArray, $headers)
    {
        $lastColumn = $this->getNameFromNumber(count($headers));
        $this->objPHPExcel = new Spreadsheet();
        $this->objPHPExcel->setActiveSheetIndex(0);
        $this->objPHPExcel->getActiveSheet()->getStyle("A1:{$lastColumn}" . (count($baseArray) + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->setColumnsStyle();
        $this->setHeadersStyle("A1:{$lastColumn}1");
        $this->setHeaders($headers);
        if ($this->addFilters) {
            $this->objPHPExcel->getActiveSheet()->setAutoFilter("A1:{$lastColumn}" . (count($baseArray) + 1));
        }
        $this->objPHPExcel->getActiveSheet()->fromArray($baseArray, '', 'A2');
    }

    /**
     * @param array $baseArray Array with the contents
     * @param array $headers Array of arrays of the headers
     * [
     * ['coordinate' => 'A1', 'title' => 'Header 1'],
     * ['coordinate' => 'B1', 'title' => 'Header 2'],
     * ['coordinate' => 'C1', 'title' => 'Header 3'],
     * ['coordinate' => 'D1', 'title' => 'Header 4'],
     * ['coordinate' => 'E1', 'title' => 'Header 5'],
     * ]
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function createFancyExportTable($baseArray, $headers)
    {
        $startRow = 10;
        $lastColumn = $this->getNameFromNumber(count($headers));
        $this->objPHPExcel = new Spreadsheet();
        $this->objPHPExcel->setActiveSheetIndex(0);
        $this->objPHPExcel->getActiveSheet()->getStyle("A{$startRow}:{$lastColumn}" . (count($baseArray) + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $objDrawing = new Drawing();
        $objDrawing->setPath('./images/img_1x/logo.png');
        $objDrawing->setCoordinates('A1');
        $objDrawing->setWorksheet($this->objPHPExcel->getActiveSheet());

        $this->setColumnsStyle();
        $this->setHeadersStyle("A{$startRow}:{$lastColumn}{$startRow}");
        $this->setHeaders($headers);
        if ($this->addFilters) {
            $this->objPHPExcel->getActiveSheet()->setAutoFilter("A{$startRow}:{$lastColumn}" . $startRow);
        }
        $this->objPHPExcel->getActiveSheet()->fromArray($baseArray, '', 'A' . ($startRow + 1));
    }

    /**
     * @param array $baseArray Array with the contents
     * @param array $headers Array of arrays of the headers
     * [
     * ['coordinate' => 'A1', 'title' => 'Header 1'],
     * ['coordinate' => 'B1', 'title' => 'Header 2'],
     * ['coordinate' => 'C1', 'title' => 'Header 3'],
     * ['coordinate' => 'D1', 'title' => 'Header 4'],
     * ['coordinate' => 'E1', 'title' => 'Header 5'],
     * ]
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function createExportTableWithHeader($baseArray, $headers)
    {
        $lastColumn = $this->getNameFromNumber(count($headers));
        $this->objPHPExcel = new Spreadsheet();
        $this->objPHPExcel->setActiveSheetIndex(0);
        $this->objPHPExcel->getActiveSheet()->getStyle("A1:{$lastColumn}" . (count($baseArray) + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->setColumnsStyle();
        $this->setHeadersStyle("A1:{$lastColumn}1");
        $this->setHeaders($headers);
        if ($this->addFilters) {
            $this->objPHPExcel->getActiveSheet()->setAutoFilter("A1:{$lastColumn}" . (count($baseArray) + 1));
        }
        $this->objPHPExcel->getActiveSheet()->fromArray($baseArray, '', 'A2');
    }

    /**
     * @param $baseArray
     * @param $headers
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function createExportTableHorizontal($baseArray, $headers)
    {
        $lastColumn = $this->getNameFromNumber(count($headers));
        $this->objPHPExcel = new Spreadsheet();
        $this->objPHPExcel->setActiveSheetIndex(0);
        $this->objPHPExcel->getActiveSheet()->getStyle("A1:{$lastColumn}" . (count($baseArray) + 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $this->setColumnsStyle();
        $this->setHeadersStyle("A1:{$lastColumn}1");
        $this->setHeaders($headers);
        if ($this->addFilters) {
            $this->objPHPExcel->getActiveSheet()->setAutoFilter("A1:{$lastColumn}" . (count($baseArray) + 1));
        }
        $this->objPHPExcel->getActiveSheet()->fromArray($baseArray, '', 'A2');
    }

    /**
     * @param $range
     * @param int $size
     * @param bool $bold
     * @param string $font_color
     * @param string $fill_type
     * @param string $start_color
     * @param string $end_color
     */
    private function setHeadersStyle($range, $size = 14, $bold = true, $font_color = 'FFFFFF', $fill_type = 'solid', $start_color = '', $end_color = '')
    {
        $this->objPHPExcel->getActiveSheet()->getStyle($range)->getFont()->setSize($size);
        $this->objPHPExcel->getActiveSheet()->getStyle($range)->getFont()->setBold($bold);
        $this->objPHPExcel->getActiveSheet()->getStyle($range)->getFont()->setColor(new Color($font_color));
        $this->objPHPExcel->getActiveSheet()->getStyle($range)->getFill()->setFillType($fill_type);
        $this->objPHPExcel->getActiveSheet()->getStyle($range)->getFill()->getStartColor()->setARGB($start_color);
        $this->objPHPExcel->getActiveSheet()->getStyle($range)->getFill()->getEndColor()->setARGB($end_color);
    }

    /**
     * @param array $coordinates_titles
     */
    private function setHeaders(array $coordinates_titles)
    {
        foreach ($coordinates_titles as $coordinates_title) {
            $this->objPHPExcel->getActiveSheet()->SetCellValue($coordinates_title['coordinate'], $coordinates_title['title']);
        }
    }

    /**
     */
    private function setColumnsStyle()
    {
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    }


    public function hideColumns(array $array)
    {
        foreach ($array as $item) {
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($item)->setVisible(false);
        }
    }

    public function autoSizeColumns(array $array)
    {
        foreach ($array as $item) {
            $this->objPHPExcel->getActiveSheet()->getColumnDimension($item)->setAutoSize(true);
        }
    }

    /**
     * @param $path
     * @param $fileName
     * @return bool|string
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function saveExcel($path, $fileName)
    {
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($this->objPHPExcel, 'Xlsx');
        $objWriter->save("{$path}/{$fileName}.xlsx");
        return \Yii::getAlias("@web/{$path}/{$fileName}.xlsx");
    }

    /**
     * @param $num
     * @return string
     */
    public function getNameFromNumber($num)
    {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = (int)(($num - 1) / 26);
        return $num2 > 0 ? $this->getNameFromNumber($num2) . $letter : $letter;
    }

    /**
     * @param $fileName
     * @param null $title
     * @param null $path
     * @param null $class
     * @return string
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function getDownloadButton($fileName, $title = null, $path = null, $class = null)
    {
        return Html::a($title !== null ? $title : $fileName, $this->saveExcel($path !== null ? $path : self::DEFAULT_PATH, $fileName), ['class' => $class !== null ? $class : 'btn btn-primary']);
    }

}
