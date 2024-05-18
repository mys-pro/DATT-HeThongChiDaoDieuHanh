<?php
view('blocks.logins.header');
view('blocks.logins.sidebar', ['active' => $active]);
view('logins.index');
view('blocks.logins.footer');
?>