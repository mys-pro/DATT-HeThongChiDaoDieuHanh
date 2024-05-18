<?php
include "./TCPDF/tcpdf.php";
class PDFController extends BaseController
{
    private $taskModel;
    public function __construct()
    {
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
        $pdf = new TCPDF();
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();
        $pdf->SetFont('Dejavuserif', 'B', 10);

        $pdf->SetLeftMargin(13);
        $pdf->Cell(0, 10, 'ỦY BAN NHÂN DÂN', 0, 0, 'L');
        $pdf->SetX($pdf->GetPageWidth() - 60);
        $pdf->Cell(0, 10, 'CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM', 0, 1, 'R');

        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(23);
        $pdf->SetY($pdf->GetY() - 5);
        $pdf->Cell(0, 10, 'HUYỆN CHÂU THÀNH', 0, 0, 'L');
        $pdf->SetX($pdf->GetPageWidth() - 100);
        $pdf->SetFont('', 'BU', 10);
        $pdf->Cell(0, 10, 'Độc lập - Tự do - Hạnh phúc', 0, 1, 'R');

        $pdf->SetFont('', '', 10);
        $pdf->SetRightMargin(10);
        $pdf->Cell(0, 5, '......., ngày.... tháng.... năm 20....', 0, 1, 'R');


        $pdf->SetFont('', 'B', 10);
        $pdf->Ln(10);
        $pdf->SetLeftMargin(0);
        $pdf->SetRightMargin(0);
        $pdf->Cell(0, 10, $title, 0, 1, 'C');


        $html = '
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên công việc</th>
                    <th>Đơn vị thực hiện</th>
                    <th>Thẩm định</th>
                    <th>Thời gian bắt đầu</th>
                    <th>Thời gian dự kiến</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <body>
        ';

        $count = 0;
        foreach($data as $value) {
            $count++;
            $Reviewr = ($value['Reviewer'] == 1) ? 'x' : '';
            $html .= '
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

        $html .= '
            </body>
        </table>
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

        $pdf->Ln(1);
        $pdf->SetFont('dejavuserif', '', 10);
        $pdf->SetLeftMargin(10);
        $pdf->SetRightMargin(10);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Ln();
        $pdf->SetFont('', 'B', 10);
        $pdf->SetLeftMargin(20);
        $pdf->SetRightMargin(20);
        $pdf->Cell(0, 10, 'PHỤ TRÁCH BỘ PHẬN', 0, 0, 'L');
        $pdf->SetX($pdf->GetPageWidth() - 60);
        $pdf->Cell(0, 10, 'NGƯỜI BÁO CÁO', 0, 1, 'R');
        $pdf->Output();
    }
}
