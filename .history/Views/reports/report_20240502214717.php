<?php
require_once "../../TFPDF/pdf_mc_table.php";

$pdf = new PDF_MC_Table();

$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',14);

$pdf->Output('example_011.pdf', 'I');
?>
