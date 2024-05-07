<?php
view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('reports.index', [
    'pageTitle' => $pageTitle, 
    'departmentFilter' =>  $departmentFilter, 
    'report' => $report,
]);
view('blocks.footer');
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
                        htmlString += '<td class="text-center">' + count + '</td>'
                                    + '<td class="text-center">' + value['TaskName'] + '</td>'
                                    + '<td class="text-center">' + value['Priority'] + '</td>'
                                    + '<td class="text-center">' + value['DepartmentName'] + '</td>'
                                    + '<td class="text-center">' + value['ExpectedDate'] + '</td>'
                                    + '<td class="text-center">' + value['CompletionDate'] + '</td>'
                                    + '<td class="text-center">' + value['Status'] + '</td>';
                    });
                    $("#list-container").html("<ul>" + htmlString + "</ul>");
                },
            });
        });
    });
</script>