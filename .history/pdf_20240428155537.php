<?php
require_once('TCPDF/tcpdf.php');

// Khởi tạo đối tượng PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Thêm trang mới
$pdf->AddPage();

// Thêm văn bản vào trang PDF
$pdf->SetFont('times', 'BI', 12);
$pdf->Write(10, 'Hello, World! This is a PDF document.');

// Kết xuất tài liệu PDF
$pdf->Output();
?>