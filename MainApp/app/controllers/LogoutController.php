<?php
/**
 * Created by PhpStorm.
 * User: ep
 * Date: 7.1.2019
 * Time: 0:52
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";

class LogoutController {

    public static function logout() {
        setcookie("cookie", $_COOKIE['cookie'], time() - 3600, "");
        ViewHelper::redirect("/");
    }
}