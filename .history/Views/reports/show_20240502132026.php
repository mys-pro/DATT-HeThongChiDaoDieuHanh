<?php
foreach($departmentFilter as $value) {
    echo $value['DepartmentID'] . '<br>';
}
die;

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
            var reportVal = $('#report-filter').val();
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
            alert(reportVal);
            $.ajax({
                url: '<?= getWebRoot() ?>/ac/bao-cao',
                method: 'POST',
                data: {
                    reportVal:reportVal,
                    date: date,
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                },
                success: function(response) {
                    report = JSON.parse(response);
                    $("#table-report").html("<p>Nội dung mới</p>");
                },
            });
        });
    });
</script>