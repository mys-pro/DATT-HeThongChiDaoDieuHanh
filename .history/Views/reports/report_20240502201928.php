<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('dejavuserif', 'B', 10);

$pdf->SetLeftMargin(13);
$pdf->Cell(0, 10, 'ỦY BAN NHÂN DÂN', 0, 0, 'L');
$pdf->SetX($pdf->GetPageWidth() - 60);
$pdf->Cell(0, 10, 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM', 0, 1, 'R');

$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(23);
$pdf->SetY($pdf->GetY() - 5);
$pdf->Cell(0, 10, 'HUYỆN CHÂU THÀNH', 0, 0, 'L');
$pdf->SetX($pdf->GetPageWidth() - 100);
$pdf->SetFont('dejavuserif', 'BU', 10);
$pdf->Cell(0, 10, 'Độc lập - Tự do - Hạnh phúc', 0, 1, 'R');

$pdf->SetFont('', '', 10);
$pdf->SetRightMargin(10);
$pdf->Cell(0, 1, '......., ngày.... tháng.... năm 20....', 0, 1, 'R');


$pdf->SetFont('', 'B', 10);
$pdf->Ln(10);
$pdf->SetLeftMargin(0);
$pdf->SetRightMargin(0);
$pdf->Cell(0, 1, 'BÁO CÁO CÔNG VIỆC NĂM 2024', 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFillColor(255);
$pdf->SetTextColor(0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

$pdf->SetLeftMargin(10);
$pdf->SetRightMargin(10);
$pdf->MultiCell(10, 10, 'STT', 1, 'C');
$pdf->MultiCell(10, 10, 'Tên công việc', 1, 0, 'C', 1);
$pdf->MultiCell(40, 10, 'Đơn vị thực hiện', 1, 0, 'C', 1);
$pdf->MultiCell(40, 10, 'Thẩm định', 1, 0, 'C', 1);
$pdf->MultiCell(40, 10, 'Thời gian bắt đầu', 1, 0, 'C', 1);
$pdf->MultiCell(40, 10, 'Thời gian dự kiến', 1, 0, 'C', 1);
$pdf->MultiCell(40, 10, 'Trạng thái', 1, 0, 'C', 1);

$pdf->Ln();

$pdf->SetFont('', 'B', 10);
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(20);
$pdf->Cell(0, 10, 'PHỤ TRÁCH BỘ PHẬN', 0, 0, 'L');
$pdf->SetX($pdf->GetPageWidth() - 60);
$pdf->Cell(0, 10, 'NGƯỜI BÁO CÁO', 0, 1, 'R');

$pdf->Output('example_011.pdf', 'I');
?>
