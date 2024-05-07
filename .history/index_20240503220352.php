<?php
require './Core/Common.php';
session_start();
echo getWebRoot();
die;
require './Core/Route.php';
require './Core/App.php';
require './Core/Database.php';
require './Models/BaseModel.php';
require './Controllers/BaseController.php';
$app = new App();

if(isset($_SESSION['UserID'])) {
    header('Location:'.getWebRoot().'/ac/thong-ke');
    exit();
} else {
    header('Location:'.getWebRoot().'/dang-nhap');
}

