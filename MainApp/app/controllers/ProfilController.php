<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 7.1.2019
 * Time: 0:39
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";

class ProfilController {

    public static function showProfil() {
        echo ViewHelper::render("app/views/profil/profil.php", []);
    }
}