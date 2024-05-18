<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('Times New Roman', 'B', 13);
$pdf->Write(13, 'UBND HUYỆN CHÂU THÀNH');

$pdf->Output();
?>
