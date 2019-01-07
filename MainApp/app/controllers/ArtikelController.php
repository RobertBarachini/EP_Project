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
  public static function artikelPage($id)
  {

    $artikli = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
    $artikli_slike = requestUtil::sendRequest('http://localhost/api/v1/artikli_slike/read.php', "GET", "");
    $artikli_ocene = requestUtil::sendRequest('http://localhost/api/v1/artikli_ocene/read.php', "GET", "");


    $taPraveSlike = array();
    $jeUporabnikZeOcenil = false;
    $ocena = 0;

    $berljiviPodatki = json_encode($artikli);
    $decodiraniPodatki = json_decode($berljiviPodatki, true);

    $berljiviPodatki_slike = json_encode($artikli_slike);
    $decodiraniPodatki_slike = json_decode($berljiviPodatki_slike, true);
    $podatki = $decodiraniPodatki_slike['body'];
    if ($artikli_ocene != null) {
      $berljiviPodatki_ocene = json_encode($artikli_ocene);
      $decodiraniPodatki_ocene = json_decode($berljiviPodatki_ocene, true);
      $podatki_ocene = $decodiraniPodatki_ocene['body'];
    }

    foreach ($podatki as $key => $value) {
      if ($value['idartikla'] == $decodiraniPodatki['idartikla']) {
        array_push($taPraveSlike, $value);
      }
    }


    if (isset($_COOKIE) && isset($_COOKIE['cookie'])) {
      $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php' . '?piskotek=' . $_COOKIE['cookie'], "GET", "");
      $berljiviPodatki_uporabnik = json_encode($uporabnik);
      $decodiraniPodatki_uporabnik = json_decode($berljiviPodatki_uporabnik, true);

      if ($artikli_ocene != null) {
        foreach ($podatki_ocene as $key => $value) {
          if ($value['iduporabnika'] == $decodiraniPodatki_uporabnik['iduporabnika'] && $id == $value['idartikla']) {
            $jeUporabnikZeOcenil = true;
            $ocena = $value['ocena'];
            break;
          }
        }
      }

    }

    echo ViewHelper::render("app/views/artikel/artikel.php", ["artikel" => $decodiraniPodatki, "artikel_slike" => $taPraveSlike, "jeZeDalOceno" => $jeUporabnikZeOcenil, "ocena" => $ocena]);
  }
}