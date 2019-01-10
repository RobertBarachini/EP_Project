<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 10.1.2019
 * Time: 0:33
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";

class AdminController {

    public static function showAdminConsole() {
        echo ViewHelper::render("app/views/admin/admin.php", []);
    }
}