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


      /* $body = array(
        "naziv" => "Test",
        "opis" => "test",
        "cena" => 2,
        "idspr" => -1
      );


      $temp = requestUtil::sendRequestPOST("http://localhost/api/v1/artikli/create.php","POST", $body);
      */

    $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read.php","GET","");
    $berljiviPodatki = json_encode($artikli);
    $decodiraniPodatki = json_decode($berljiviPodatki,true);
    $podatki = $decodiraniPodatki['body'];

    $artikli_slike = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli_slike/read.php","GET","");
    $berljiviPodatki_slike = json_encode($artikli_slike);
    $decodiraniPodatki_slike = json_decode($berljiviPodatki_slike,true);
    $podatki_slike = $decodiraniPodatki_slike['body'];

    /* var_dump($podatki[1]);
    foreach($podatki as $key => $art) {
      echo ($art['naziv']);
    } */

    echo ViewHelper::render("app/views/index-page.php",["artikli"=>$podatki,"artikli_slike"=>$podatki_slike]);
  }
}