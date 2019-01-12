<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 4.1.2019
 * Time: 08:33
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class RegisterController
{

  public static function registerUser()
  {
    echo ViewHelper::render("app/views/register/register.php", []);
  }

  public static function preveriVnoseInIzvediRegistracijo($POST) {
      error_reporting(E_ALL & ~E_DEPRECATED);

    $ime = $POST['ime'];
    $priimek = $POST['priimek'];
    $ulica = $POST['ulica'];
    $kraj = $POST['kraj'];
    $posta = $POST['posta'];
    $drzava = $POST['drzava'];
    $email = $POST['email'];
    $geslo = $POST['geslo'];

    //captcha
    $secretKey = "6LfwGokUAAAAAHdkA6b3HZwXgpJXSVL7Ia9jvPjV";
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP = $_SERVER['REMOTE_ADDR'];

    $urr = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $responseFromGoogle = file_get_contents($urr);

    $responseFromGoogle = json_decode($responseFromGoogle, true)['success'];
    # Check if there are empty fields
    if (empty($ime) || empty($priimek) || empty($ulica)
      || empty($kraj) || empty($posta) || empty($drzava) || empty($geslo) || empty($email)) {
        echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Izpolnite vsa polja!
                                    </div>";
    } else {
      # Check if first and lastname are in correct form
      if (!preg_match("/^[a-zA-Z]*$/", $ime) || !preg_match("/^[a-zA-Z]*$/", $priimek)) {
          echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Ime in priimek lahko vsebujeta samo črke!
                                    </div>";
      } else {
        #Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Elektronski naslov mora biti pravilne oblike (_@_._) 
                                    </div>";
        } else if ($responseFromGoogle) {
          $salt = RegisterController::generateRandomString();
          $hpwd = password_hash($geslo, PASSWORD_DEFAULT, ['salt' => $salt]);
          $hashedPassword = password_hash($hpwd . $salt, PASSWORD_DEFAULT, ['salt' => $salt]);

          $uporabnik_arr = array(
            "idvloge" => "S",
            "idcert" => null,
            "email" => "$email",
            "indmailpotrjen" => 0,
            "geslo" => "$hashedPassword",
            "sol" => "$salt",
            "piskotek" => null,
            "ime" => "$ime",
            "priimek" => "$priimek",
            "ulica" => "$ulica",
            "posta" => "$posta",
            "kraj" => "$kraj",
            "drzava" => "$drzava",
            "idspr" => 0,
            "status" => 0,
          );
          $temp = requestUtil::sendRequestPOST("http://localhost/trgovina/api/v1/uporabniki/create.php", "POST", $uporabnik_arr);

            if($temp != "{\"id\":-1,\"message\":\"Unable to create object.\"}") {
                echo "<div class=\"alert alert-success errorImg\">
                                        <strong>Registracija uspešna!</strong> 
                                        <a href='"; echo ROOT_URL . 'login'; echo "'>Prijavite se</a> 
                                    </div>";
            } else {
                echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong>
                                    </div>";
            }
        } else {
          var_dump("Si robot!"); //treba malo olepšat stvari ma zaenkrat najj bo tako
        }

      }
    }
  }

  public static function generateRandomString($length = 60)
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }
}