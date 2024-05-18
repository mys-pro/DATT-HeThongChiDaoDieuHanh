<?php
    view('blocks.tasks.header');
    view('blocks.tasks.sidebar', ['active' => $active]);
    view('blocks.tasks.footer');
?>

<script>
    $(document).ready(function() {
        $('.sidebar__content-item > a:([data-bs-toggle="collapse"])').click(function() {
            
        });
    });
</script>