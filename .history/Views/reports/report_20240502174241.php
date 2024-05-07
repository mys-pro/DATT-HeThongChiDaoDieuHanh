<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('dejavuserif', 'B', 10);
// $pdf->Write(10, 'UBND HUYỆN CHÂU THÀNH');
$pdf->MultiCell(80, 10, 'UBND HUYỆN CHÂU THÀNH', 0, 'L');
// $x = $pdf->GetX();
// $y = $pdf->GetY();
$pdf->SetX($pdf->GetPageWidth() - 10);
$pdf->MultiCell(80, 10, 'Chữ bên phải', 0, 'R');


$pdf->Output();
?>
