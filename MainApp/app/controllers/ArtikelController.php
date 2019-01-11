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
    //Requesti
    $artikli = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
    $artikli_slike = requestUtil::sendRequest('http://localhost/api/v1/artikli_slike/read.php', "GET", "");
    $artikli_ocene = requestUtil::sendRequest('http://localhost/api/v1/artikli_ocene/read.php', "GET", "");
    $narocila = requestUtil::sendRequestGET('http://localhost/api/v1/narocila/read.php', "GET","");
    $narocila_artikli = requestUtil::sendRequestGET('http://localhost/api/v1/narocila_artikli/read.php', "GET","");

    if($narocila == "{\"message\":\"No objects found.\"}") {
      $narocila = '';
      $narocila = json_decode($narocila);
    }

    if($narocila_artikli == "{\"message\":\"No objects found.\"}") {
      $narocila_artikli = "";
      $narocila_artikli = json_decode($narocila_artikli);
    }

    //Potrebne Spremenljivke
    $taPraveSlike = array();
    $jeUporabnikZeOcenil = false;
    $idUporabnika = 1;
    $ocena = 0;
    $jeZeVKosarici = false;

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
      //uporabnik
      $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php' . '?piskotek=' . $_COOKIE['cookie'], "GET", "");
      $berljiviPodatki_uporabnik = json_encode($uporabnik);
      $decodiraniPodatki_uporabnik = json_decode($berljiviPodatki_uporabnik, true);
      //narocila
      //$berljiviPodatki_narocila = json_encode($narocila);
      //$decodiraniPodatki_narocila = json_decode($berljiviPodatki_narocila, true);
      $narocilaP = json_decode($narocila,true)['body'];
      //narocila_artikli
      //$berljiviPodatki_narocila_artikli = json_encode($narocila_artikli);
      //$decodiraniPodatki_narocila_artikli = json_decode($berljiviPodatki_narocila_artikli, true);
      $narocila_artikliP = json_decode($narocila_artikli,true)['body'];


      $idUporabnika = $decodiraniPodatki_uporabnik['iduporabnika'];


      // poglej za ocene
      if ($artikli_ocene != null) {
        foreach ($podatki_ocene as $key => $value) {
          if ($value['iduporabnika'] == $decodiraniPodatki_uporabnik['iduporabnika'] && $id == $value['idartikla']) {
            $jeUporabnikZeOcenil = true;
            $ocena = $value['ocena'];
            break;
          }
        }
      }

      // poglej za kosarico

      if ($narocilaP != null) {
        foreach ($narocilaP as $key => $value) {
          if ($narocila_artikliP != null) {
            foreach($narocila_artikliP as $key_ar => $value_ar) {
              if($value['faza'] == 'K' && $value['idnarocila'] == $value_ar['idnarocila'] && $id == $value_ar['idartikla'] && $decodiraniPodatki_uporabnik['iduporabnika'] == $value['iduporabnika']) {
                $jeZeVKosarici = true;
                break;
              }

            } if($jeZeVKosarici) break;
          } else break;

        }
      } else $jeZeVKosarici = false;

    }

    echo ViewHelper::render("app/views/artikel/artikel.php", ["artikel" => $decodiraniPodatki, "artikel_slike" => $taPraveSlike, "jeZeDalOceno" => $jeUporabnikZeOcenil, "ocena" => $ocena, "iduporabnika" => $idUporabnika, "ocenil" => $jeZeVKosarici]);
  }
}