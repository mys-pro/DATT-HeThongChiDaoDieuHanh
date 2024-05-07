<?php
require_once dirname(dirname(__DIR__))."/TFPDF/pdf_mc_table.php";

$pdf = new PDF_MC_Table();

$pdf->AddPage();
$pdf->SetFont('DejaVu','',14);

$pdf->Output('example_011.pdf', 'I');
?>
