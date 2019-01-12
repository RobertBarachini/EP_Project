<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 7.1.2019
 * Time: 0:39
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";

class ProfilController
{

  public static function showProfil()
  {
    echo ViewHelper::render("app/views/profil/profil.php", []);
  }

  public static function showEdit()
  {
    echo ViewHelper::render("app/views/profil/edit/edit.php", []);
  }

  public static function showEditPassword()
  {
    echo ViewHelper::render("app/views/profil/edit/password.php", []);
  }

  public static function editProfil($uporabnik, $POST)
  {
    # Users' new data
    $ime = $POST['ime'];
    $priimek = $POST['priimek'];
    $ulica = $POST['ulica'];
    $kraj = $POST['kraj'];
    $posta = $POST['posta'];
    $drzava = $POST['drzava'];
    $email = $POST['email'];
    $id = $uporabnik['iduporabnika'];
    $idvloge = $uporabnik['idvloge'];
    $idcert = $uporabnik['idcert'];
    $indmailpotrjen = $uporabnik['indmailpotrjen'] == null ? "0" : $uporabnik['indmailpotrjen'];
    $geslo = $uporabnik['geslo'];
    $sol = $uporabnik['sol'];
    $piskotek = $uporabnik['piskotek'];
    $datprijave = date("Y-m-d H:i:s");
    $idspr = $uporabnik['idspr'] == null ? "1" : $uporabnik['idspr'];
    $datspr = date("Y-m-d H:i:s");
    $status = $uporabnik['status'];

    # For body of request
    $uporabnik_arr = array(
      "iduporabnika" => $id,
      "idvloge" => "$idvloge",
      "idcert" => "$idcert",
      "email" => "$email",
      "indmailpotrjen" => "$indmailpotrjen",
      "geslo" => "$geslo",
      "sol" => "$sol",
      "piskotek" => "$piskotek",
      "ime" => "$ime",
      "priimek" => "$priimek",
      "ulica" => "$ulica",
      "posta" => "$posta",
      "kraj" => "$kraj",
      "drzava" => "$drzava",
      "datprijave" => "$datprijave",
      "idspr" => "$idspr",
      "datspr" => "$datspr",
      "status" => "$status",
    );

    # Update user
    requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/uporabniki/update.php', "PUT", $uporabnik_arr);
    ViewHelper::redirect('/profil');
  }

  public static function changePassword($POST)
  {
    error_reporting(E_ALL & ~E_DEPRECATED);
    # Get uporabnik by cookie value
    $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php' . '?piskotek=' . $_COOKIE['cookie'], "GET", "");

    if ($uporabnik == null) {
      # Handle exception -> unknown user

    } else {
      $berljiviPodatki = json_encode($uporabnik);
      $decodiraniPodatki = json_decode($berljiviPodatki, true);

      $checkOld = self::checkOldPassword($decodiraniPodatki, $POST['staro']);

      if ($checkOld) {
        if (self::checkIfNewMatches($POST['novo1'], $POST['novo2'])) {
          $novoGeslo = $POST['novo1'];
          $salt = $decodiraniPodatki['sol'];
          $hpwd = password_hash($novoGeslo, PASSWORD_DEFAULT, ['salt' => $salt]);
          $hashedPassword = password_hash($hpwd . $salt, PASSWORD_DEFAULT, ['salt' => $salt]);

          self::updatePassword($decodiraniPodatki, $hashedPassword);

            echo "<div class=\"alert alert-success errorImg\">
                                        <strong>Geslo uspešno posodobljeno!</strong> 
                                        Nazaj na <a href='"; echo ROOT_URL . 'profil'; echo "'>urejanje profila</a> 
                                    </div>";

        } else {
            echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Nova gesla se ne ujemata
                                    </div>";
        }
      } else {
          echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Napačno geslo
                                    </div>";
      }
    }
  }

  public static function checkOldPassword($uporabnik, $geslo)
  {
    $salt = $uporabnik['sol'];
    $hpwd = password_hash($geslo, PASSWORD_DEFAULT, ['salt' => $salt]);
    $hashedPassword = password_hash($hpwd . $salt, PASSWORD_DEFAULT, ['salt' => $salt]);

    if ($hashedPassword == $uporabnik['geslo']) {
      # Correct password
      return true;
    } else {
      # Wrong old password
      return false;
    }
  }

  public static function checkIfNewMatches($geslo1, $geslo2)
  {
    if ($geslo1 == $geslo2) {
      return true;
    }
    return false;
  }

  public static function updatePassword($decodiraniPodatki, $hashedPassword)
  {
    $id = $decodiraniPodatki['iduporabnika'];
    $idvloge = $decodiraniPodatki['idvloge'];
    $idcert = $decodiraniPodatki['idcert'];
    $email = $decodiraniPodatki['email'];
    $indmailpotrjen = $decodiraniPodatki['indmailpotrjen'] == null ? "0" : $decodiraniPodatki['indmailpotrjen'];
    $geslo = $hashedPassword;
    $sol = $decodiraniPodatki['sol'];
    $piskotek = $decodiraniPodatki['piskotek'];
    $ime = $decodiraniPodatki['ime'];
    $priimek = $decodiraniPodatki['priimek'];
    $ulica = $decodiraniPodatki['ulica'];
    $posta = $decodiraniPodatki['posta'];
    $kraj = $decodiraniPodatki['kraj'];
    $drzava = $decodiraniPodatki['drzava'];
    $idspr = $decodiraniPodatki['idspr'] == null ? "1" : $decodiraniPodatki['idspr'];
    $status = $decodiraniPodatki['status'];
    $datprijave = date("Y-m-d H:i:s");
    $datspr = date("Y-m-d H:i:s");

    // Update user to get user cookie in database
    $uporabnik_arr = array(
      "iduporabnika" => $id,
      "idvloge" => "$idvloge",
      "idcert" => "$idcert",
      "email" => "$email",
      "indmailpotrjen" => "$indmailpotrjen",
      "geslo" => "$geslo",
      "sol" => "$sol",
      "piskotek" => "$piskotek",
      "ime" => "$ime",
      "priimek" => "$priimek",
      "ulica" => "$ulica",
      "posta" => "$posta",
      "kraj" => "$kraj",
      "drzava" => "$drzava",
      "datprijave" => "$datprijave",
      "idspr" => "$idspr",
      "datspr" => "$datspr",
      "status" => "$status",
    );
    requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/uporabniki/update.php', "PUT", $uporabnik_arr);
  }

  public static function narocilaPage($id)
  {
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

    $narocila = json_decode($narocila, true)['body'];
    $narocila_artikli = json_decode($narocila_artikli, true)['body'];

    $narocilaArray = array();

    foreach($narocila as $key => $value) {
      if($value['iduporabnika'] == $id && ($value['faza'] == 'N' ||  $value['faza'] == 'P' || $value['faza'] == 'S' || $value['faza'] == 'Z')) {
        array_push($narocilaArray,$value);
      }
    }
    $temp = -1;

    foreach ($narocila_artikli as $key => $value) {
      $temp = self::jeNotr($value['idnarocila'],$narocilaArray);
      $artt = self::artikelZaPushat($value['idartikla'],$podatki);

      if($temp != -1) {
        if($artt != null) {
          $cenaArtikla = $artt['cena'];
          $nazivArtikla = $artt ['naziv'];
          array_push($value,$cenaArtikla);
          array_push($value,$nazivArtikla);

          //var_dump($value);

        }
        array_push($narocilaArray[$temp],$value);

      }

      $ceneSkupne = array();
    }
    foreach($narocilaArray as $key => $value ) {
      $skupnaCena  = 0;
      //$i = 0; $j = 0;
      foreach ($value as $temp) {
          if(is_array($temp)) {
            $skupnaCena += ($temp['0'] * $temp['kolicina']);
          }
      }

      array_push($ceneSkupne,$skupnaCena);
      //$j += 1;
    }

    //var_dump($narocilaArray); die();

    //var_dump($narocilaArray); die();

    //var_dump($narocila, $narocila_artikli);die();
    echo ViewHelper::render("app/views/profil/narocila/narocila.php", ["narocilaPodatki" => $narocilaArray, "ceneSkupne" =>$ceneSkupne]);
  }

  public static function jeNotr($idNarocila, $narocilaArray){
    foreach ($narocilaArray as $key => $value) {
      if($value['idnarocila'] == $idNarocila) {
        return $key;
      }
    }
    return -1;
  }
  public static function artikelZaPushat($idartiklaVNarocilu, $podatki) {
    foreach($podatki as $key => $value) {
      if($value['idartikla'] == $idartiklaVNarocilu) {
        return $value;
      }
    }
    return null;
  }

}