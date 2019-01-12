<?php
/**
 * Created by PhpStorm.
 * User: aleksandarhristov
 * Date: 3.1.2019
 * Time: 18:30
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class VerifyController
{
  public static function verifyPage($id1, $id2)
  {

    $zeObstaja = 0;
    $uporabnik = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id1, "GET", "");
    $berljiviPodatki = json_encode($uporabnik);
    $decodiraniPodatki = json_decode($berljiviPodatki, true);

    if($decodiraniPodatki['indmailpotrjen'] != 0) {
      $uporabniki_potrditve = requestUtil::sendRequest("http://localhost/trgovina/api/v1/uporabniki_potrditve/read.php", "GET", "");
      $berljiviPodatki_potrditve = json_encode($uporabniki_potrditve);
      $decodiraniPodatki_potrditve = json_decode($berljiviPodatki_potrditve, true);
      $podatki_potrditve = $decodiraniPodatki_potrditve['body'];



      foreach($podatki_potrditve as $key => $value) {
        if($id1 == $value['iduporabnika'] && $id2 == $value['idspr']) {
          $body = array(
              "iduporabnika" => $decodiraniPodatki['iduporabnika'],
              "idvloge" => $decodiraniPodatki['idvloge'] ,
              "idcert"=> $decodiraniPodatki['idcert'] ,
              "email"=> $decodiraniPodatki['email'] ,
              "indmailpotrjen"=> "0",
              "geslo"=> $decodiraniPodatki['geslo'] ,
              "sol"=> $decodiraniPodatki['sol'] ,
              "piskotek"=> $decodiraniPodatki['piskotek'] ,
              "ime"=> $decodiraniPodatki['ime'] ,
              "priimek"=> $decodiraniPodatki['priimek'] ,
              "ulica"=>$decodiraniPodatki['ulica'] ,
              "posta"=> $decodiraniPodatki['posta'] ,
              "kraj"=> $decodiraniPodatki['kraj'] ,
              "drzava"=> $decodiraniPodatki['drzava'],
              "datprijave"=> "2018-12-30 16:15:46",
              "status"=> $decodiraniPodatki['status'] ,
              "datspr"=> "2019-01-02 10:05:14",
              "idspr"=> "-1"
          );
          $odgovor = requestUtil::sendRequestPUT("http://localhost/api/v1/uporabniki/update.php", "PUT", $body);
          $zeObstaja = 1;
          break;
        }
      }
    }



    echo ViewHelper::render("app/views/verify/verify.php", ['zeObstaja' => $zeObstaja]);
  }
}