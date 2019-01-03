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
    $berljiviPodatki = json_encode($artikli);
    $decodiraniPodatki = json_decode($berljiviPodatki,true);
    $podatki = $decodiraniPodatki['body'];
    /* var_dump($podatki[1]);
    foreach($podatki as $key => $art) {
      echo ($art['naziv']);
    } */

    echo ViewHelper::render("app/views/index-page.php",["artikli"=>$podatki,"varA" =>'lolek']);
  }
}