<?php
foreach($statistical as $item ) {
    echo $item;
    echo '<br>';
}
die;

view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('statistical.index', ['pageTitle' => $pageTitle]);
view('blocks.footer');