<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 4.1.2019
 * Time: 08:33
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class RegisterController {

    public static function registerUser() {
        echo ViewHelper::render("app/views/register/register.php", []);
    }
}