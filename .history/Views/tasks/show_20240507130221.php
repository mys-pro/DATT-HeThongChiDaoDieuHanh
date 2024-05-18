<?php
    view('blocks.tasks.header');
    view('blocks.tasks.sidebar', ['active' => $active]);
    view('tasks.index');
    view('blocks.tasks.footer');
?>