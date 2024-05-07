<?php
    view('blocks.tasks.header');
    view('blocks.tasks.sidebar', ['active' => $active]);
    view('tasks.index', ['pageTitle' => $pageTitle]);
    view('blocks.tasks.footer');
?>