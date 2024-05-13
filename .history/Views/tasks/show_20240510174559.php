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

            setTimeout(fetchDataAndUpdate, 1);
        }
    })
</script>