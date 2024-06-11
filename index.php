<?php
session_start();

require './library/PHPMailer/src/PHPMailer.php';
require './library/PHPMailer/src/Exception.php';
require './library/PHPMailer/src/SMTP.php';
require './library/TCPDF/tcpdf.php';
require './library/Pusher/vendor/autoload.php';

require './Core/Common.php';
require './Core/Route.php';
require './Core/App.php';
require './Core/Database.php';
require './Models/BaseModel.php';
require './Controllers/BaseController.php';
$app = new App();