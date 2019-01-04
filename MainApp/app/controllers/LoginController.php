<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 4.1.2019
 * Time: 10:12
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class LoginController {

    public static function loginUser() {
        echo ViewHelper::render("app/views/login/login.php", []);
    }
}