<?php
include "./TFPDF/pdf_mc_table.php";
class PDFController extends BaseController
{
    private $pdf;
    private $taskModel;
    public function __construct()
    {
        $this->pdf = new PDF_MC_Table();
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function report()
    {
        $report = $this->taskModel->reportByYear();

        $this->pdf->AddPage();
        $this->pdf->AddFont('Dejavuserif', '', 'Dejavuserif.ttf', true);
        $this->pdf->AddFont('Dejavuserif', 'B', 'Dejavuserif-Bold.ttf', true);
        $this->pdf->AddFont('Dejavuserif', 'BI', 'Dejavuserif-BoldItalic.ttf', true);
        $this->pdf->AddFont('Dejavuserif', 'I', 'Dejavuserif-Italic.ttf', true);
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

        $this->pdf->Ln(10);
        $this->pdf->SetWidths(array(20, 30));
        $this->pdf->SetAligns(array('C', 'L'));
        $this->pdf->SetLineHeight(5);
        $data = array(
            array('1', 'Sản phẩm A'),
            array('2', 'Sản phẩm B'),
            array('3', 'Sản phẩm C')
        );
        
        // Thêm các hàng vào bảng
        foreach ($data as $row) {
            $this->pdf->Row($row);
        }

        $this->pdf->Output();
    }
}
