<?php
view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('reports.index', ['pageTitle' => $pageTitle]);
view('blocks.footer');