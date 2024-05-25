<?php
session_start();

require './Core/Common.php';
require './Core/pusher_setup.php';
require './Core/Route.php';
require './Core/App.php';
require './Core/Database.php';
require './Models/BaseModel.php';
require './Controllers/BaseController.php';
$app = new App();
