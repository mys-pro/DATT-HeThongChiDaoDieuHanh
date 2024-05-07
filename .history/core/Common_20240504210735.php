<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
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
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;   
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 587;
        $mail->isHTML(true);
        $mail->Username = 'codetest4589@gmail.com'; // Email và mật khẩu SMTP
        $mail->Password = 'pwez vikp xnsz glhw';

        $mail->setFrom('codetest4589@gmail.com');
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->addAddress($to);

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}