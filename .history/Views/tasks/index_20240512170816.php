<?php
view('blocks.tasks.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view('tasks.index', ['data' => $data]);
view('blocks.tasks.footer');
