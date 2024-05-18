<?php
view('tasks.partitions.header');
view('blocks.tasks.sidebar', ['active' => $active]);
view($page, ['data' => $data]);
view('blocks.tasks.footer');
