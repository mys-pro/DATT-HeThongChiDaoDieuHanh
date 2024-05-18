<?php
$htmlFile = __DIR__.'/index.php';
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4');

$pdf->AddPage();

$pdf->Output();

$dom = new DOMDocument();
?>
