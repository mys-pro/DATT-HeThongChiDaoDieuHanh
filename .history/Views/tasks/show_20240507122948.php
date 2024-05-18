<?php
    view('blocks.tasks.header');
    view('blocks.tasks.sidebar', ['active' => $active]);
    view('blocks.tasks.footer');
?>

<script>
    $(document).ready(function() {
    });
</script>