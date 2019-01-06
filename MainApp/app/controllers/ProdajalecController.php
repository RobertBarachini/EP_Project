<?php

require_once "ViewHelper.php";
require_once "requestUtil.php";

class ProdajalecController {

  public static function prodajalec() {


    echo ViewHelper::render("app/views/prodajalec/uploadPicture.php", []);
  }
}