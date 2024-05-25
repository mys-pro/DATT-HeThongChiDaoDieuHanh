<?php
view('tasks.partitions.header');
view('tasks.partitions.sidebar', ['active' => $active]);
view($page, ['data' => $data]);
view('tasks.partitions.footer');