<?php
session_start();

require './Core/Common.php';
require './Core/Route.php';
require './Core/App.php';
require './Core/Database.php';
require './Controllers/BaseController.php';
$app = new App();