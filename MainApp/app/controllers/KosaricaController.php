<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 4.1.2019
 * Time: 10:12
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class KosaricaController {

  public static function kosaricaPage($id) {
    echo ViewHelper::render("app/views/kosarica/kosarica.php", []);
  }
}