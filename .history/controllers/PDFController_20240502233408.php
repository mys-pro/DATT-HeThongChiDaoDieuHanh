<?php
include "./TFPDF/pdf_mc_table.php";
class PDFController extends BaseController{
    private $pdf;
    public function __construct() {
        $this->pdf = new PDF();
    }
    public function report() {
        echo __METHOD__;
    }
}