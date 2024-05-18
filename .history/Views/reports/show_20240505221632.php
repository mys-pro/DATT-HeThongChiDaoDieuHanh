<?php
view('blocks.tasks.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view('reports.index', [
    'pageTitle' => $pageTitle,
    'departmentFilter' =>  $departmentFilter,
    'report' => $report,
]);
view('blocks.tasks.footer');
?>
<script>
    $(document).ready(function() {
        var report = <?= json_encode($report) ?>;
        $('#btn-filter-statistical').click(function() {
            var department = $('#department-filter').val();
            var date = $('#date-filter').val();
            var dateStart = 0;
            var dateEnd = 0;
            var toDate = $('#date-input').val().split(" to ");
            if ($('#date-input').val() != "") {
                if (toDate[0] != null) {
                    var dateTemp = toDate[0].split("-");
                    dateStart = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                }

                if (toDate[1] != null) {
                    var dateTemp = toDate[1].split("-");
                    dateEnd = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                }
            }
            $.ajax({
                url: '<?= getWebRoot() ?>/ac/bao-cao',
                method: 'POST',
                data: {
                    department: department,
                    date: date,
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                },
                success: function(response) {
                    report = JSON.parse(response);
                    console.log(report);
                    var htmlString = "";
                    var count = 0
                    report.forEach(value => {
                        count++;
                        var reviewerCheck = '';
                        if (value['Reviewer'] == 1) {
                            reviewerCheck = 'x';
                        }
                        htmlString += '<tr>\n' +
                            '<td class="text-center">' + count + '</td>\n' +
                            '<td class="text-center">' + value['TaskName'] + '</td>\n' +
                            '<td class="text-center">' + value['DepartmentName'] + '</td>\n' +
                            '<td class="text-center">' + reviewerCheck + '</td>' +
                            '<td class="text-center">' + value['DateCreated'] + '</td>\n' +
                            '<td class="text-center">' + value['ExpectedDate'] + '</td>\n' +
                            '<td class="text-center">' + value['Status'] + '</td>\n'; +
                        '</tr>';
                    });
                    $("#table-report > tbody").html(htmlString);
                },
            });
        });

        $('#Export-report').click(function() {
            var content = $("#table-report").html();
            console.log(noiDungHTML);
            // var department = $('#department-filter').val();
            // var date = $('#date-filter').val();
            // var dateStart = 0;
            // var dateEnd = 0;
            // var toDate = $('#date-input').val().split(" to ");
            // if ($('#date-input').val() != "") {
            //     if (toDate[0] != null) {
            //         var dateTemp = toDate[0].split("-");
            //         dateStart = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
            //     }

            //     if (toDate[1] != null) {
            //         var dateTemp = toDate[1].split("-");
            //         dateEnd = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
            //     }
            // }
            // $.ajax({
            //     url: '<?= getWebRoot() ?>/PDF/report',
            //     method: 'POST',
            //     data: {
            //         department: department,
            //         date: date,
            //         dateStart: dateStart,
            //         dateEnd: dateEnd,
            //     },
            //     xhrFields: {
            //         responseType: 'blob' // Xác định dạng dữ liệu nhận được là blob (file)
            //     },
            //     success: function(response) {
            //         var blob = new Blob([response], {
            //             type: 'application/pdf'
            //         });
            //         var link = document.createElement('a');
            //         link.href = window.URL.createObjectURL(blob);
            //         link.download = 'BaoCao.pdf';
            //         document.body.appendChild(link);
            //         link.click();
            //         document.body.removeChild(link);
            //     },
            //     error: function(xhr, status, error) {
            //         console.error('Lỗi khi gửi POST request:', error);
            //     }
            // });
        });
    });
</script>