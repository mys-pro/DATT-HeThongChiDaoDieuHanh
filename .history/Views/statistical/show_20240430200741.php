<h1>Thống kê</h1>
<?php
echo '<pre>';
print_r($statistical);
die;

view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('statistical.index', ['pageTitle' => $pageTitle]);
view('blocks.footer');