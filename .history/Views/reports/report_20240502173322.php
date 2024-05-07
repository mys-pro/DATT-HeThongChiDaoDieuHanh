<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('times', '', 13);

$pdf->AddPage();

$pdf->Write('HelloWord');

$pdf->Output();
?>
