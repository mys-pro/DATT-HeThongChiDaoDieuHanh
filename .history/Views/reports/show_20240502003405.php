<?php
foreach($report as $value) {
    echo $value . "<br>";
}
die;

view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('reports.index', ['pageTitle' => $pageTitle, 'report' => $report]);
view('blocks.footer');