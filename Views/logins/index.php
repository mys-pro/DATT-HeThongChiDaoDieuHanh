<?php
view('logins.partitions.header');
view($page, ['data' => isset($data) ? $data : []]);
view('logins.partitions.footer');