<?php
require_once "Router.php";

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
//razdelimo Url na stringe po slashih

session_start();
$_SESSION["lala"] = "neki";
$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

Router::handleRouters($path);