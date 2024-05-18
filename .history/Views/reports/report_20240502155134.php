<?php
$htmlFile = __DIR__.'/index.php';
require_once dirname(dirname(__DIR__))."/TCPDF/tcpdf.php";

$pdf = new TCPDF('P', 'mm', 'A4');

$pdf->AddPage();

// $pdf->Output();

$dom = new DOMDocument();
$dom->loadHTMLFile($htmlFile);

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
?>
