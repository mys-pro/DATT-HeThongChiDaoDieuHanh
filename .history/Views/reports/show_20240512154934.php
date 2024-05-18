<?php
view('blocks.tasks.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view('reports.index', [
    'pageTitle' => $pageTitle,
    'departmentFilter' =>  $departmentFilter,
    'report' => $report,
]);
view('blocks.tasks.footer');
