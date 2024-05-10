<?php
include "./library/TCPDF/tcpdf.php";
class PDFController extends BaseController
{
    private $pdf;
    private $taskModel;
    public function __construct()
    {
        $this->pdf = new TCPDF('P', 'mm', 'A4');
        $this->loadModel('TaskModel');
        $this->taskModel = new TaskModel();
    }
    public function report()
    {
        if (isset($_POST['department']) && isset($_POST['date'])) {
            if ($_POST['date'] == "DATE" && $_POST['dateStart'] != 0) {
                if($_POST['dateEnd'] == 0) {
                    $title = 'BÁO CÁO TÌNH HÌNH CHỈ ĐẠO TRONG NGÀY ' . date("d-m-Y", strtotime($_POST['dateStart']));
                } else {
                    $title = 'BÁO CÁO TÌNH HÌNH CHỈ ĐẠO TỪ NGÀY ' . date("d-m-Y", strtotime($_POST['dateStart'])) . ' ĐẾN NGÀY ' . date("d-m-Y", strtotime($_POST['dateEnd']));
                }
                $report = $this->taskModel->reportByDate($_POST['department'], $_POST['dateStart'], $_POST['dateEnd']);
            } else if ($_POST['date'] == 'MONTH') {
                $title = 'BÁO CÁO TÌNH HÌNH CHỈ DẠO TRONG THÁNG '. date("m");
                $report = $this->taskModel->reportByMonth($_POST['department']);
            } else {
                $title = 'BÁO CÁO TÌNH HÌNH CHỈ DẠO TRONG NĂM '. date("Y");
                $report = $this->taskModel->reportByYear($_POST['department']);
            }
        } else {
            $title = 'BÁO CÁO TÌNH HÌNH CHỈ DẠO TRONG NĂM '. date("Y");
            $report = $this->taskModel->reportByYear();
        }
        $this->downloadReport($title, $report);
    }

    private function downloadReport($title, $data)
    {
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
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

        $html = '
        <table>
        <thead>
            <tr>
                <th scope="col" width="30px">STT</th>
                <th scope="col" width="128px">Tên công việc</th>
                <th scope="col" width="100px">Đơn vị thực hiện</th>
                <th scope="col" width="50px">Thẩm định</th>
                <th scope="col" width="80px">Thời gian bắt đầu</th>
                <th scope="col" width="80px">Thời gian dự kiến</th>
                <th scope="col" width="70px">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
        ';

        $count = 0;
        foreach ($data as $value) {
            $count++;
            $Reviewr = ($value['Reviewer'] == 1) ? 'x' : '';
            $html .= '
                <tr>
                    <td>' . $count . '</td>
                    <td>' . $value['TaskName'] . '</td>
                    <td>' . $value['DepartmentName'] . '</td>
                    <td>' . $Reviewr . '</td>
                    <td>' . $value['DateCreated'] . '</td>
                    <td>' . $value['ExpectedDate'] . '</td>
                    <td>' . $value['Status'] . '</td>
                </tr>
            ';
        }

        $html .= '
        </tbody>
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
        $this->pdf->Output('BaoCao.pdf', 'D');
        exit;
    }
}