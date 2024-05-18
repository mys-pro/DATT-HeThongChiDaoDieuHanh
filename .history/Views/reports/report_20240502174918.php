<?php
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();

$pdf->SetFont('dejavuserif', 'B', 13);
$pdf->Cell(0, 13, 'ỦY BAN NHÂN DÂN', 0, 0, 'L');

$pdf->SetX($pdf->GetPageWidth() - 60);
$pdf->Cell(0, 13, 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM', 0, 1, 'R');


$pdf->Output();
?>
