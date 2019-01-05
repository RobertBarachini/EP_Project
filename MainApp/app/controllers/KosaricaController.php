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

    $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read.php","GET","");
    $berljiviPodatki = json_encode($artikli);
    $decodiraniPodatki = json_decode($berljiviPodatki,true);
    $podatki = $decodiraniPodatki['body'];

    echo ViewHelper::render("app/views/kosarica/kosarica.php", ["artikli"=>$podatki,"varA" =>'lolek']);
  }
}