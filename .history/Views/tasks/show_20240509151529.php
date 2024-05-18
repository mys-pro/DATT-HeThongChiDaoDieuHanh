<?php
view('blocks.tasks.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view('tasks.index', ['pageTitle' => $pageTitle, 'taskList' => $taskList]);
view('blocks.tasks.footer');
?>

<script>
    $(document).ready(function() {
        const $cell1Elements = $('[data-cell="Tình trạng"]');
        $cell1Elements.each(function() {
            const dataValue = $(this).getAttribute('data-value');
            if(dataValue == "Hoàn thành trước hạn") {
                $(this).children().addClass("bg-success text-success");
            }
            // $(this).children().removeClass("text-bg-primary");
            // $(this).children().removeClass("text-bg-success");
            // $(this).children().removeClass("text-bg-warning");
            // $(this).children().removeClass("text-bg-info");
            // $(this).children().removeClass("text-bg-secondary");
            // $(this).children().removeClass("text-bg-danger");

        });
    })
</script>