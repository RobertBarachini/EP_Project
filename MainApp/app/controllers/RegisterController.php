<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 4.1.2019
 * Time: 08:33
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class RegisterController {

    public static function registerUser() {
        echo ViewHelper::render("app/views/register/register.php", []);
    }

    public static function preveriVnoseInIzvediRegistracijo($POST) {

        $ime = $POST['ime'];
        $priimek = $POST['priimek'];
        $ulica = $POST['ulica'];
        $kraj = $POST['kraj'];
        $posta = $POST['posta'];
        $drzava = $POST['drzava'];
        $email = $POST['email'];
        $geslo = $POST['geslo'];

        # Check if there are empty fields
        if(empty($ime) || empty($priimek) || empty($ulica)
            || empty($kraj) || empty($posta) || empty($drzava) || empty($geslo)) {
            ViewHelper::redirect('/register?register=empty');
        } else {
            # Check if first and lastname are in correct form
            if(!preg_match("/^[a-zA-Z]*$/", $ime) || !preg_match("/^[a-zA-Z]*$/", $priimek)) {
                ViewHelper::redirect('/register?register=invalid');
            } else {
                #Check if email is valid
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    ViewHelper::redirect('/register?register=email');
                } else {
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
                    requestUtil::sendRequestPOST("http://localhost/trgovina/api/v1/uporabniki/create.php","POST",$uporabnik_arr);
                    ViewHelper::redirect('/login');
                }
            }
        }
    }

    public static function generateRandomString($length = 60) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}