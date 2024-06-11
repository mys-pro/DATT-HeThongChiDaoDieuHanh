<?php
view('admins.partitions.header', ['quantityNotify' => $quantityNotify]);
view('admins.partitions.sidebar', ['active' => $active]);
view($page, ['active' => $active, 'data' => $data]);
view('admins.partitions.footer');