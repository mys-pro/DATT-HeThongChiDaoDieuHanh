<?php
require_once dirname(dirname(__DIR__))."/TFPDF/tfpdf.php";

$pdf = new TFPDF('P', 'mm', 'A4', true, 'UTF-8', false);


$pdf->Output('example_011.pdf', 'I');
?>
