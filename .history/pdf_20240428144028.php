<?php
include('./TCPDF/tcpdf.php');

$pdf = new TCPDF('p', 'mm', 'A4');

$pdf->AddPage();

$pdf->Output();

?>