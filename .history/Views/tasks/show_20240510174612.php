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
        function fetchDataAndUpdate() {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    fetchData: true
                },
                success: function(data) {
                    var tableData = $(data).find('#table-data').html()
                    $('#table-data').html(tableData);
                }
            });

            setTimeout(fetchDataAndUpdate, 2);
        }

        function customStatus() {
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

            setTimeout(customStatus, 1);
        }
    })
</script>