<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 4.1.2019
 * Time: 08:33
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";
require_once "emailService/PHPMailerAutoload.php";


class RegisterController
{

  public static function registerUser()
  {
    echo ViewHelper::render("app/views/register/register.php", []);
  }

  public static function preveriVnoseInIzvediRegistracijo($POST)
  {
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
      echo "<div class=\"alert alert-danger errorImg\" style=\" position: relative; margin-left : auto; margin-right: auto\">
                                        <strong>Napaka!</strong> Izpolnite vsa polja!
                                    </div>";
    } else {
      # Check if first and lastname are in correct form
      if (!preg_match("/^[a-zA-Z]*$/", $ime) || !preg_match("/^[a-zA-Z]*$/", $priimek)) {
        echo "<div class=\"alert alert-danger errorImg\" style=\" position: relative; margin-left : auto; margin-right: auto\">
                                        <strong>Napaka!</strong> Ime in priimek lahko vsebujeta samo črke!
                                    </div>";
      } else {
        #Check if email is valid
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          echo "<div class=\"alert alert-danger errorImg\" style=\" position: relative; margin-left : auto; margin-right: auto\">
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
            "indmailpotrjen" => 1,
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
          $uporabnikResponse = requestUtil::sendRequestPOST("http://localhost/trgovina/api/v1/uporabniki/create.php", "POST", $uporabnik_arr);
          if ($uporabnikResponse != "{\"id\":-1,\"message\":\"Unable to create object.\"}") {
            $uporabnikResponse = json_decode($uporabnikResponse, true)['id'];
            // pripravi Podatke za posiljanje maila
            $hashiranaVrednost = hash('sha256', $email);
            $potrditevBody = array(
              "iduporabnika" => $uporabnikResponse,
              "idspr" => $hashiranaVrednost
            );

            requestUtil::sendRequestPOST("http://localhost/api/v1/uporabniki_potrditve/create.php", "POST", $potrditevBody);
            $urlString = "https://localhost/verify/$uporabnikResponse/$hashiranaVrednost";

            self::emailUtil($email, $urlString);

            echo "<div class=\"alert alert-success errorImg\" style=\" position: relative; margin-left : auto; margin-right: auto\">
                                        <strong>Registracija uspešna! Prvo Potrdite svoj email</strong> 
                                        <a href='";
            echo ROOT_URL . 'login';
            echo "'>Prijavite se</a> 
                                    </div>";
          } else {
            echo "<div class=\"alert alert-danger errorImg\" style=\" position: relative; margin-left : auto; margin-right: auto\">
                                        <strong>Napaka!</strong>
                                    </div>";
          }

          ViewHelper::redirect('/login');
        } else {
          echo "<div class=\"alert alert-danger errorImg\" style=\" position: relative; margin-left : auto; margin-right: auto\">
                                        <strong>Prosim obkljukajte CAPTCHO.</strong>
                                    </div>";
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

  public static function emailUtil($sendToEmail, $urlZaBody)
  {
    // Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
    //Load Composer's autoloader
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
      //Server settings
      //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'eptrgovina18@gmail.com';                 // SMTP username
      $mail->Password = 'EPtrgovina2018';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to
      //Recipients
      $mail->setFrom('eptrgovina18@gmail.com', 'TopShopBrt');
      $mail->addAddress($sendToEmail, 'Uporabnik');     // Add a recipient
      $mail->addReplyTo('eptrgovina18@gmail.com');
      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Verificiraj svoj Email!';
      $mail->Body = 'Kliknite na link: ' . $urlZaBody . ' za aktivacijo racuna.';
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $mail->send();
      echo 'Message has been sent';
    } catch (Exception $e) {
      echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
  }
}