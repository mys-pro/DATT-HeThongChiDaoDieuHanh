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
            alert(reportVal);
            $.ajax({
                url: '<?= getWebRoot() ?>/ac/bao-cao',
                method: 'POST',
                data: {
                },
                success: function(response) {

                },
            });
        });
    });
</script>