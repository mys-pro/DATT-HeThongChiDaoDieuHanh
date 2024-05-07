<?php
session_start();

require './Core/Common.php';
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

