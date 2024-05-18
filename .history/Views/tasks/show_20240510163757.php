<?php
view('blocks.tasks.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view('tasks.index', [
    'pageTitle' => $pageTitle,
    'taskList' => $taskList
]);
view('blocks.tasks.footer');
?>

<script>
    $(document).ready(function() {
        const $cell1Elements = $('[data-cell="Tình trạng"]');
        $cell1Elements.each(function() {
            const dataValue = $(this).attr('data-value');
            if (dataValue == "Hoàn thành trước hạn") {
                $(this).children().addClass("bg-primary text-primary");
            } else if (dataValue == "Hoàn thành") {
                $(this).children().addClass("bg-success text-success");
            } else if (dataValue == "Hoàn thành trễ hạn") {
                $(this).children().addClass("bg-warning text-warning");
            } else if (dataValue == "Chờ duyệt") {
                $(this).children().addClass("bg-info text-info");
            } else if (dataValue == "Trễ hạn") {
                $(this).children().addClass("bg-danger text-danger");
            } else {
                $(this).children().addClass("bg-secondary text-secondary");
            }
        });

        function fetchDataAndUpdate() {
            $.ajax({
                url: 'fetch_data.php', // Đường dẫn đến file PHP xử lý yêu cầu AJAX
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Xử lý dữ liệu nhận được từ máy chủ
                    var rows = '';
                    $.each(data, function(index, record) {
                        rows += '<tr>';
                        rows += '<td>' + record.id + '</td>';
                        rows += '<td>' + record.name + '</td>';
                        rows += '<td>' + record.email + '</td>';
                        rows += '</tr>';
                    });
                    $('#data-table tbody').html(rows); // Cập nhật nội dung của bảng
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        }

        setInterval(fetchDataAndUpdate, 1);
    })
</script>