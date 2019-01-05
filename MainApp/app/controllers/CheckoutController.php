<?php

require_once "ViewHelper.php";
require_once "requestUtil.php";

class CheckoutController {

  public static function checkoutPage($id1,$id2) {

    $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read.php","GET","");
    $berljiviPodatki = json_encode($artikli);
    $decodiraniPodatki = json_decode($berljiviPodatki,true);
    $podatki = $decodiraniPodatki['body'];

    echo ViewHelper::render("app/views/checkout/checkout.php", ["artikli"=>$podatki]);
  }
}