<?php
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
    if (!empty($folder) && $folder[0] !== '/') {
        $folder = '/' . $folder;
    }
    return $web_root . $folder;
}

const VIEW_FOLDER_NAME = 'Views';
function view($viewPath, array $data = [])
{
    foreach ($data as $key => $value) {
        $$key = $value;
    }
    require(VIEW_FOLDER_NAME . '/' . str_replace('.', '/', $viewPath) . '.php');
}

function getActiveMenu($active, $name)
{
    if ($active == $name)
        echo "active";
}

function getDropdownList($active, $name)
{
    if ($active == $name) {
        echo "collapse";
    } else {
        echo "collapsed";
    }
}

function getDropdownItem($active, $name)
{
    if ($active == $name) {
        echo "show";
    }
}

function sendMail($to, $subject, $body)
{
    $mail = new PHPMailer();
    try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'codetest4589@gmail.com';
        $mail->Password = 'pwez vikp xnsz glhw';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->CharSet = 'UTF-8';

        $mail->setFrom('codetest4589@gmail.com', 'Mailer');
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

function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

function checkRole($listRole = [], $role) {
    foreach($listRole as $value) {
        if($value["RoleID"] == $role) {
            return true;
        }
    }
    return false;
}

function sendPusherEvent($channel, $event, $data) {
    $options = array(
        'cluster' => 'ap1',
        'useTLS' => true
    );
    $pusher = new Pusher\Pusher(
        '6cb0dc56f5ed27c15171',
        'c460faf87f477aad2e0a',
        '1808591',
        $options
    );

    $pusher->trigger($channel, $event, $data);
}