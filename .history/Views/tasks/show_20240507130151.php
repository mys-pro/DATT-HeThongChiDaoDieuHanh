<?php
    view('blocks.tasks.header');
    view('blocks.tasks.sidebar', ['active' => $active]);
    view('blocks.tasks.index');
    view('blocks.tasks.footer');
?>