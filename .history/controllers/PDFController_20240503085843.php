<?php
include "./TCPDF/tcpdf.php";
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
        $report = $this->taskModel->reportByYear();
        $this->downloadReport('BÁO CÁO TÌNH HÌNH CHỈ ĐAO TRONG NĂM 2024', $report);
    }

    private function downloadReport($title, $data)
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


        $thead = '
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

        $tbody = '';
        $count = 0;
        foreach($data as $value) {
            $count++;
            $Reviewr = '';
            if($value['Reviewer'] == 1)
                $Reviewr = 'x';
            $tbody .= '
                <tr>
                    <td">'.$count.'</td>
                    <td">'.$value['TaskName'].'</td>
                    <td">'.$value['DepartmentName'].'</td>
                    <td">'.$Reviewr.'</td>
                    <td">'.$value['DateCreated'].'</td>
                    <td">'.$value['ExpectedDate'].'</td>
                    <td">'.$value['Status'].'</td>
                </tr>
            ';
        }
        $tbody = '<tbody>'.$tbody.'</tbody>';
        $table = '<table>'.$thead.$tbody.'</table>';

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
        $this->pdf->writeHTML($html, true, false, true, false, '');

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
