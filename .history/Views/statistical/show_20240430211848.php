<?php
foreach($statistical as $key => $value) {
    echo $value;
    echo '<br>';
}
die;

view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('statistical.index', ['pageTitle' => $pageTitle]);
view('blocks.footer');