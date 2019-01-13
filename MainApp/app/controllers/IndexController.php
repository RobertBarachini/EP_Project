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

    $podatki = null;
    $podatki_slike = null;

    if($_SERVER['QUERY_STRING'] == "" || $_SERVER['QUERY_STRING'] == "query=") {
      $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read.php","GET","");
      $berljiviPodatki = json_encode($artikli);
      $decodiraniPodatki = json_decode($berljiviPodatki,true);
      $podatki = $decodiraniPodatki['body'];

      $artikli_slike = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli_slike/read.php","GET","");
      $berljiviPodatki_slike = json_encode($artikli_slike);
      $decodiraniPodatki_slike = json_decode($berljiviPodatki_slike,true);
      $podatki_slike = $decodiraniPodatki_slike['body'];
    } else {
      $poizvedba = substr($_SERVER['QUERY_STRING'],6);
      $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read_query.php?poizvedba=" . $poizvedba,"GET","");
      $berljiviPodatki = json_encode($artikli);
      $decodiraniPodatki = json_decode($berljiviPodatki,true);
      $podatki = $decodiraniPodatki['body'];

      $artikli_slike = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli_slike/read.php","GET","");
      $berljiviPodatki_slike = json_encode($artikli_slike);
      $decodiraniPodatki_slike = json_decode($berljiviPodatki_slike,true);
      $podatki_slike = $decodiraniPodatki_slike['body'];

    }
    $prazno = false;
    if($podatki == null) $prazno = true;

    echo ViewHelper::render("app/views/index-page.php",["artikli"=>$podatki,"artikli_slike"=>$podatki_slike, "prazno" => $prazno]);
  }
}