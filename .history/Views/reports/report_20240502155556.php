<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->Output();
?>
