<?php
/**
 * Created by PhpStorm.
 * User: aleksandarhristov
 * Date: 3.1.2019
 * Time: 18:30
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class IndexController
{
  public static function indexPage() {

    $artikli = requestUtil::sendRequest("http://localhost/storm/MainApp/api/v1/artikli/read.php","GET","");
    var_dump($artikli);
    //echo ViewHelper::render("app/views/index-page.php",["varA"=>"LakaLaka"]);
  }
}