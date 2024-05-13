<?php
view('blocks.tasks.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view($page, ['data' => $data]);
view('blocks.tasks.footer');
