<?php
view('blocks.logins.header');
view('blocks.logins.sidebar', ['active' => $active]);
view('reports.index', [
    'pageTitle' => $pageTitle,
    'departmentFilter' =>  $departmentFilter,
    'report' => $report,
]);
view('blocks.logins.footer');
?>