<?php
require('mc_table.php');

function GenerateWord()
{
	// Get a random word
	$nb = rand(3, 10);
	$w = '';
	for($i=1;$i<=$nb;$i++)
		$w .= chr(rand(ord('a'), ord('z')));
	return $w;
}

function GenerateSentence()
{
	// Get a random sentence
	$nb = rand(1, 10);
	$s = '';
	for($i=1;$i<=$nb;$i++)
		$s .= GenerateWord().' ';
	return substr($s, 0, -1);
}

$pdf = new PDF_MC_Table();
$pdf->AddPage();
$pdf->AddFont('Dejavuserif','','Dejavuserif.ttf',true);
$pdf->AddFont('Dejavuserif','B','Dejavuserif-Bold.ttf',true);
$pdf->AddFont('Dejavuserif','BI','Dejavuserif-BoldItalic.ttf',true);
$pdf->AddFont('Dejavuserif','I','Dejavuserif-Italic.ttf',true);
$pdf->SetFont('Dejavuserif','B',10);
// Table with 20 rows and 4 columns
$pdf->SetWidths(array(30, 50));
$pdf->Row(Array('1', 'Công việc 1'));
$pdf->Output();
?>
