<?php
/**
 * Created by PhpStorm.
 * User: aleksandarhristov
 * Date: 3.1.2019
 * Time: 18:30
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class ArtikelController
{
  public static function artikelPage($id) {

    $artikli = requestUtil::sendRequest('http://localhost/trgovina/api/v1/artikli/read_one.php' . '?id=' . $id, "GET","");
    $artikli_slike = requestUtil::sendRequest('http://localhost/trgovina/api/v1/artikli_slike/read_one.php' . '?id=' . $id, "GET","");

    #$artikli = requestUtil::sendRequest('http://localhost/trgovina/api/v1/artikli/read_one.php' . '?id=' . $id, "PUT","");

    $berljiviPodatki = json_encode($artikli);
    $decodiraniPodatki = json_decode($berljiviPodatki,true);

    $berljiviPodatki_slike = json_encode($artikli_slike);
    $decodiraniPodatki_slike = json_decode($berljiviPodatki_slike,true);


    echo ViewHelper::render("app/views/artikel/artikel.php", ["artikel"=>$decodiraniPodatki,"artikel_slike"=>$decodiraniPodatki_slike]);
  }
}