<?php
view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('reports.index', ['pageTitle' => $pageTitle, 'report' => $report]);
view('blocks.footer');
?>
<script>
    $(document).ready(function() {
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
            // $.ajax({
            //     url: '<?= getWebRoot() ?>/ac/bao-cao',
            //     method: 'POST',
            //     data: {
            //     },
            //     success: function(response) {

            //     },
            // });
        });
    });
</script>