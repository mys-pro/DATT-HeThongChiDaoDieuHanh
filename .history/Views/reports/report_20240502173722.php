<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('arialuni', 'B', 10);
$pdf->Write(10, 'UBND HUYỆN CHÂU THÀNH');

$pdf->Output();
?>
