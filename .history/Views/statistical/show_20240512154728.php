<?php
view('blocks.tasks.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view('statistical.index', ['pageTitle' => $pageTitle, 'statistical' => $statistical]);
view('blocks.tasks.footer');