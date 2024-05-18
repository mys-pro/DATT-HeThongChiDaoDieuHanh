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
            const valueInside = $(this).children();
            console.log(valueInside);
        });
    })
</script>