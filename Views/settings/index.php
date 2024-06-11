<?php
view('settings.partitions.header', ['quantityNotify' => $quantityNotify]);
view('settings.partitions.sidebar', ['active' => $active]);
view($page, ['data' => $data]);
view('settings.partitions.footer');