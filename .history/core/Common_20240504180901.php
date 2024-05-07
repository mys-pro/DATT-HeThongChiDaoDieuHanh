<?php
include '../library/PHPMailer/src/PHPMailer.php';
include '../library/PHPMailer/src/PHPMailer.php';
include '../library/PHPMailer/src/PHPMailer.php';

function getWebRoot()
{
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $web_root = 'https://' . $_SERVER['HTTP_HOST'];
    } else {
        $web_root = 'http://' . $_SERVER['HTTP_HOST'];
    }

    $doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
    $current_dir = str_replace($doc_root, '', str_replace('\\', '/', dirname(__DIR__)));
    $folder = ($current_dir === '/' ? '' : $current_dir);
    return $web_root . $folder;
}

const VIEW_FOLDER_NAME = 'Views';
function view($viewPath, array $data = []) {
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require (VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php');
}

function getActiveMenu($active, $name) {
    if($active == $name) 
        echo "active";
}