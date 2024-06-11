<?php
view('tasks.partitions.header', ['quantityNotify' => $quantityNotify]);
view('tasks.partitions.sidebar', ['active' => $active]);
view($page, ['data' => $data]);
view('tasks.partitions.footer');