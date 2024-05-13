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
        }
        customStatus();

        function fetchDataAndUpdate() {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    fetchData: true
                },
                success: function(response) {
                    var tableData = $(response).find('#table-data').html();
                    console.log(tableData);
                    // var data = JSON.parse(response);
                    // var html = "";
                    // data.forEach((value, index) => {
                    //     html += '<tr>\n' +
                    //         '<td data-cell="STT" class="text-center">' + (index + 1) + '</td>\n' +
                    //         '<td data-cell="Tên công việc" class="text-start text-break">' + value["TaskName"] + '</td>\n' +
                    //         '<td data-cell="Tình trạng" class="text-start" data-value="' + value["Status"] + '">\n' +
                    //             '<span class="badge bg-opacity-25 fw-semibold">\n' + value["Status"] + '</span>\n' +
                    //         '</td>\n' +
                    //         '<td data-cell="Người giao" class="text-start">\n' +
                    //             '<img class="rounded-circle" src="data:image/jpeg;base64,' + value["Avatar"] + '" alt="" width="32px" height="32px">\n' +
                    //             '<span class="ms-2">' + value["FullName"] + '</span>\n' +
                    //         '</td>\n' +
                    //         '<td data-cell="Hạn hoàn thành" class="text-center">' + value["Deadline"] + '</td>\n' +
                    //         '<td data-cell="Tiến độ" class="text-center">\n' +
                    //             '<div class="progress progress-task" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">\n' +
                    //                 '<div class="progress-bar" style="width: ' + value["Progress"] + '%">\n' +
                    //                     value["Progress"] + '%' +
                    //                 '</div>\n' +
                    //             '</div>\n' +
                    //         '</td>\n' +
                    //     '</tr>';
                    // });
                
                    // $("#table-data > tbody").html(html);
                    customStatus();
                },
            });
        }

        setInterval(fetchDataAndUpdate, 3000);
    })
</script>