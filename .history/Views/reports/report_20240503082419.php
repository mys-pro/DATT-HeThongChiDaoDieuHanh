<?php
include "../../TCPDF/tcpdf.php";

$pdf = new TCPDF();

$pdf->AddPage();
$pdf->SetFont('Dejavuserif','B',10);

$pdf->SetLeftMargin(13);
$pdf->Cell(0, 10, 'ỦY BAN NHÂN DÂN', 0, 0, 'L');
$pdf->SetX($pdf->GetPageWidth() - 60);
$pdf->Cell(0, 10, 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM', 0, 1, 'R');

$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(23);
$pdf->SetY($pdf->GetY() - 5);
$pdf->Cell(0, 10, 'HUYỆN CHÂU THÀNH', 0, 0, 'L');
$pdf->SetX($pdf->GetPageWidth() - 100);
$pdf->SetFont('', 'BU', 10);
$pdf->Cell(0, 10, 'Độc lập - Tự do - Hạnh phúc', 0, 1, 'R');

$pdf->SetFont('', '', 10);
$pdf->SetRightMargin(10);
$pdf->Cell(0, 5, '......., ngày.... tháng.... năm 20....', 0, 1, 'R');


$pdf->SetFont('', 'B', 10);
$pdf->Ln(10);
$pdf->SetLeftMargin(0);
$pdf->SetRightMargin(0);
$pdf->Cell(0, 10, 'BÁO CÁO TÌNH TRẠNG CÔNG VIỆC NĂM 2024', 0, 1, 'C');

$pdf->Ln(10);
$pdf->SetWidths(Array(20, 30));
$pdf->SetLineHeight(5);
$pdf->SetFont('Dejavuserif','',10);
$pdf->Row(Array('1', 'Công việc 1'));

$pdf->Output();
?>
