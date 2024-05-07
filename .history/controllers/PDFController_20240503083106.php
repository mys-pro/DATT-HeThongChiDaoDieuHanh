<?php
include "./TFPDF/pdf_mc_table.php";
class PDFController extends BaseController
{
    private $pdf;
    private $taskModel;
    public function __construct()
    {
        $this->pdf = new TCPDF();
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function report()
    {
    }

    private function download($title, $data)
    {
        $this->pdf->AddPage();
        $this->pdf->SetFont('Dejavuserif', 'B', 10);

        $this->pdf->SetLeftMargin(13);
        $this->pdf->Cell(0, 10, 'ỦY BAN NHÂN DÂN', 0, 0, 'L');
        $this->pdf->SetX($this->pdf->GetPageWidth() - 60);
        $this->pdf->Cell(0, 10, 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM', 0, 1, 'R');

        $this->pdf->SetLeftMargin(10);
        $this->pdf->SetRightMargin(23);
        $this->pdf->SetY($this->pdf->GetY() - 5);
        $this->pdf->Cell(0, 10, 'HUYỆN CHÂU THÀNH', 0, 0, 'L');
        $this->pdf->SetX($this->pdf->GetPageWidth() - 100);
        $this->pdf->SetFont('', 'BU', 10);
        $this->pdf->Cell(0, 10, 'Độc lập - Tự do - Hạnh phúc', 0, 1, 'R');

        $this->pdf->SetFont('', '', 10);
        $this->pdf->SetRightMargin(10);
        $this->pdf->Cell(0, 5, '......., ngày.... tháng.... năm 20....', 0, 1, 'R');


        $this->pdf->SetFont('', 'B', 10);
        $this->pdf->Ln(10);
        $this->pdf->SetLeftMargin(0);
        $this->pdf->SetRightMargin(0);
        $this->pdf->Cell(0, 10, 'BÁO CÁO TÌNH TRẠNG CÔNG VIỆC NĂM 2024', 0, 1, 'C');

        $this->pdf->Ln(1);
        $this->pdf->SetFont('dejavuserif', '', 10);
        $this->pdf->SetLeftMargin(10);
        $this->pdf->SetRightMargin(10);
        $this->pdf->writeHTML($data, true, false, true, false, '');

        $this->pdf->Ln();
        $this->pdf->SetFont('', 'B', 10);
        $this->pdf->SetLeftMargin(20);
        $this->pdf->SetRightMargin(20);
        $this->pdf->Cell(0, 10, 'PHỤ TRÁCH BỘ PHẬN', 0, 0, 'L');
        $this->pdf->SetX($this->pdf->GetPageWidth() - 60);
        $this->pdf->Cell(0, 10, 'NGƯỜI BÁO CÁO', 0, 1, 'R');
        $this->pdf->Output();
    }
}
