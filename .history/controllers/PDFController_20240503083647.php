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
        $this->taskModel->reportByYear();
    }

    private function download($title, $columnName, $data)
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
        $this->pdf->Cell(0, 10, $title, 0, 1, 'C');


        $rowTitle = '';
        foreach($columnName as $item) {
            $rowTitle .= '
                <th scope="col">'.$item.'</th>
            ';
        }

        $html = '
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
        ';

        $css = '
        <style>
            table {
                border-collapse: collapse;
            }

            th, td {
                text-align: center;
                border: 1px solid black;
            }
        </style>
        ';

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
