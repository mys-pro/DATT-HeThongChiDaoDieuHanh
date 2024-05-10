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
            <td><?= $count ?></td>
            <td><?= $value['TaskName'] ?></td>
            <td><?= $value['DepartmentName'] ?></td>
            <td><?php if ($value['Reviewer'] == 1) echo "x" ?></td>
            <td><?= $value['DateCreated'] ?></td>
            <td><?= $value['ExpectedDate'] ?></td>
            <td><?= $value['Status'] ?></td>
        </tr>
    </tbody>
</table>
';

$pdf->Output();
?>