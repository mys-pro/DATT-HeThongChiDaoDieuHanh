<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('dejavuserif', 'B', 10);
// $pdf->Write(10, 'UBND HUYỆN CHÂU THÀNH');
$pdf->Cell(80, 10, 'Chữ bên trái', 0, 0, 'L'); // 80 là chiều rộng của ô văn bản bên trái

// Văn bản bên phải
$pdf->SetX($pdf->GetPageWidth() - 130); // 130 là tổng chiều rộng của cả hai ô văn bản
$pdf->Cell(50, 10, 'Chữ bên phải', 0, 1, 'R')


$pdf->Output();
?>
