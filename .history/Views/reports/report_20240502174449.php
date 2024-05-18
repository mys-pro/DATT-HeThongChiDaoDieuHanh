<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('dejavuserif', 'B', 10);
$pdf->Cell(80, 10, 'UBND HUYỆN CHÂU THÀNH', 0, 0, 'L');

$pdf->SetX($pdf->GetPageWidth() - 50);
$pdf->Cell(50, 10, 'Chữ bên phải', 0, 1, 'R');


$pdf->Output();
?>
