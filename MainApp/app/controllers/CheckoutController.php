<?php

require_once "ViewHelper.php";
require_once "requestUtil.php";

class CheckoutController {

  public static function checkoutPage($id1,$id2) {

    $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read.php", "GET", "");
    $berljiviPodatki = json_encode($artikli);
    $decodiraniPodatki = json_decode($berljiviPodatki, true);
    $podatki = $decodiraniPodatki['body'];

    $narocila = requestUtil::sendRequestGET("http://localhost/trgovina/api/v1/narocila/read.php", "GET", "");
    $narocila_artikli = requestUtil::sendRequestGET("http://localhost/trgovina/api/v1/narocila_artikli/read.php", "GET", "");

    if ($narocila == "{\"message\":\"No objects found.\"}") {
      $narocila = '';
      $narocila = json_decode($narocila);
    }

    if ($narocila_artikli == "{\"message\":\"No objects found.\"}") {
      $narocila_artikli = "";
      $narocila_artikli = json_decode($narocila);
    }

    $narocilaP = json_decode($narocila, true)['body'];
    $narocila_artikliP = json_decode($narocila_artikli, true)['body'];
    $idArray = array();
    $podatkiArray = array();
    $podatkiNarocila = array();
    $idNarocila = null;
    $skupnaCena = 0;
    if ($narocilaP != null) {
      foreach ($narocilaP as $key => $value) {
        if ($narocila_artikliP != null) {
          foreach ($narocila_artikliP as $key_ar => $value_ar) {
            if ($value['faza'] == 'K' && $value['idnarocila'] == $value_ar['idnarocila'] && $id1 == $value['iduporabnika']) {
              array_push($idArray, $value_ar['idartikla']);
              array_push($podatkiNarocila, $value_ar);
              $idNarocila = $value['idnarocila'];
            }
          }

        } else break;
      }
    }

    foreach ($podatki as $key => $value) {
      foreach ($idArray as $ke => $val) {
        if ($value['idartikla'] == $val) {
          array_push($podatkiArray, $value);
        }
      }
    }

    $slikeArray = array();
    $artikli_slike = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli_slike/read.php", "GET", "");
    $berljiviPodatki_slike = json_encode($artikli_slike);
    $decod = json_decode($berljiviPodatki_slike, true);
    $artikli_slike_P = $decod['body'];

    foreach ($podatkiArray as $key => $value) {
      foreach ($artikli_slike_P as $ke => $val) {
        if ($val['idartikla'] == $value['idartikla']) {
          array_push($slikeArray, $val);
          $skupnaCena += $podatkiNarocila[$key]['kolicina']*$value['cena'];
          break;
        }
      }
    }
   // $skupnaCena = floor($skupnaCena);
    //sortiramo po artiklih za lazje updejtanje ocen
    function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
      $sort_col = array();
      foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
      }

      array_multisort($sort_col, $dir, $arr);
    }


    array_sort_by_column($podatkiNarocila, 'idartikla');

    //var_dump($podatkiNarocila);die();
    echo ViewHelper::render("app/views/checkout/checkout.php", ["artikli" => $podatkiArray, "slike" => $slikeArray, "podatkiZaNarocilo" => $podatkiNarocila, "uporab" => $id1, "idNarocila" => $id2, "cenaS" => $skupnaCena]);
  }
}