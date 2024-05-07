<?php
include "./TFPDF/pdf_mc_table.php";
class PDFController extends BaseController{
    private $pdf;
    private $taskModel;
    public function __construct() {
        $this->pdf = new PDF_MC_Table();
    }
    public function report() {
        $report = $this->taskModel->reportByYear();
    }
}