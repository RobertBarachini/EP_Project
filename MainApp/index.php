<?php
require_once "Router.php";

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define("ROOT_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php"));
//razdelimo Url na stringe po slashih

session_start();
$_SESSION["lala"] = "neki";
$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

Router::handleRouters($path);