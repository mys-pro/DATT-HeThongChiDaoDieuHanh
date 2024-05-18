<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('dejavuserif', 'B', 10);
$x = $pdf->GetX();
$y = $pdf->GetY();

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

$pdf->SetFont('dejavuserif', 'B', 10);
$pdf->Ln(10);
$pdf->SetLeftMargin(0);
$pdf->SetRightMargin(0);
$pdf->Cell(0, 10, 'BÁO CÁO CÔNG VIỆC NĂM 2024', 0, 1, 'C');

$html = '
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../public/Image/icon.png" />
	<title>Hệ thống chỉ đạo điều hành</title>
	<link rel="stylesheet" href="../public/css/material_blue.css">
	<link rel="stylesheet" href="../bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="../public/css/Styles.css">
</head>

<table>
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên công việc</th>
            <th scope="col">Đơn vị thực hiện</th>
            <th scope="col">Thẩm định</th>
            <th scope="col">Thời gian bắt đầu</th>
            <th scope="col">Thời gian dự kiến</th>
            <th scope="col">Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Công việc 1</td>
            <td>Văn phòng</td>
            <td>x</td>
            <td>03-04-2024</td>
            <td>18-04-20224</td>
            <td>Hoàn thành</td>
        </tr>
    </tbody>
</table>
';

$pdf->Ln(1);
$pdf->SetFont('dejavuserif', '', 10);
$pdf->writeHTMLCell($pdf->GetPageWidth() - 20, 0, 9 ,'', $html, 0);

$pdf->Output();
?>
