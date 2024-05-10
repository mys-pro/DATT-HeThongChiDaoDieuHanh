<?php
include './library/PHPMailer/src/PHPMailer.php';
include './library/PHPMailer/src/Exception.php';
include './library/PHPMailer/src/OAuth.php';
include './library/PHPMailer/src/POP3.php';
include './library/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

function sendMail($to, $subject, $body) {
    $mail = new PHPMailer();
    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp1.example.com;smtp2.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'codetest4589@gmail.com';
        $mail->Password = 'pwez vikp xnsz glhw';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('codetest4589@gmail.com', 'Test Code');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}