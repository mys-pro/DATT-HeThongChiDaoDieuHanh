<?php
$htmlFile = __DIR__.'/report.php';
echo $htmlFile;
die;
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4');

$pdf->AddPage();

$pdf->Output();

$dom = new DOMDocument();
?>
