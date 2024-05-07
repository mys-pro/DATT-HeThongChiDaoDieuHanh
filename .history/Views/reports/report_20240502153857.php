<?php
$htmlFile = 'report.php';
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

// Khởi tạo đối tượng TCPDF mới
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Thiết lập thông tin tài liệu
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Table to PDF');
$pdf->SetSubject('Exporting table to PDF');
$pdf->SetKeywords('PDF, table, export');

// Thiết lập thông số font
$pdf->SetFont('helvetica', '', 12);

// Thêm một trang mới
$pdf->AddPage();

// Khởi tạo đối tượng DOMDocument
$dom = new DOMDocument();

// Load HTML từ file
$dom->loadHTMLFile($htmlFile);

// Lấy danh sách các thẻ <table> từ tài liệu HTML
$tables = $dom->getElementsByTagName('table');

// Kiểm tra xem có ít nhất một bảng tồn tại trong file HTML không
if ($tables->length > 0) {
    // Lấy thẻ <table> đầu tiên (có thể điều chỉnh tùy ý)
    $table = $tables->item(0);

    // Chuyển đổi thẻ <table> thành chuỗi HTML
    $tableHtml = $dom->saveHTML($table);

    // Thêm nội dung HTML của bảng vào tài liệu PDF
    $pdf->writeHTML($tableHtml, true, false, true, false, '');

    // Kết xuất file PDF vào đường dẫn cụ thể
    $pdf->Output('table.pdf', 'F');
} else {
    echo 'Không tìm thấy bảng dữ liệu trong file HTML.';
}
