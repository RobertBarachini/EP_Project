<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 4.1.2019
 * Time: 10:12
 */
require_once "ViewHelper.php";
require_once "requestUtil.php";

class LoginController {

    public static function loginUser() {
        echo ViewHelper::render("app/views/login/login.php", []);
    }

    public static function login($email, $geslo) {
        # Check if there are empty fields
        if(empty($email) || empty($geslo)) {
            ViewHelper::redirect('/login?login=empty');
        } else {
            # Search for uporabnik by email
            $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_email.php'  . '?email=' . $email, "GET", "");
            $berljiviPodatki = json_encode($uporabnik);
            $decodiraniPodatki = json_decode($berljiviPodatki,true);

            # Check if uporabnik exists
            if($uporabnik == null) {
                ViewHelper::redirect('/login?login=unknownUser');
            } else {
                # Check if password is correct
                $salt = $decodiraniPodatki['sol'];
                $hpwd = password_hash($geslo, PASSWORD_DEFAULT, ['salt' => $salt]);

                $hashedPassword = password_hash($hpwd . $salt, PASSWORD_DEFAULT, ['salt' => $salt]);
                $expectedPassword = $decodiraniPodatki['geslo'];

                $verifyPassword = ($expectedPassword == $hashedPassword) ? true : false;

                if(!$verifyPassword) {
                    ViewHelper::redirect('/login?login=wrongPasswordOrEmail');
                } elseif($verifyPassword) {

                    # Password for user is correct give him cookie
                    if($decodiraniPodatki['piskotek'] == null) {

                        # Generate new random cookie and add it to user

                        $name = "cookie";
                        $value = LoginController::generateRandomString();
                        setcookie($name, $value, time() + 3200, "/");

                        $id = $decodiraniPodatki['iduporabnika'];
                        $idvloge = $decodiraniPodatki['idvloge'];
                        $idcert = $decodiraniPodatki['idcert'];
                        $email = $decodiraniPodatki['email'];
                        $indmailpotrjen = $decodiraniPodatki['indmailpotrjen'];
                        $geslo = $decodiraniPodatki['geslo'];
                        $sol = $decodiraniPodatki['sol'];
                        $ime = $decodiraniPodatki['ime'];
                        $priimek = $decodiraniPodatki['priimek'];
                        $ulica = $decodiraniPodatki['ulica'];
                        $posta = $decodiraniPodatki['posta'];
                        $kraj = $decodiraniPodatki['kraj'];
                        $drzava = $decodiraniPodatki['drzava'];
                        $idspr = $decodiraniPodatki['idspr'];
                        $status = $decodiraniPodatki['status'];
                        $datprijave = $decodiraniPodatki['datprijave'];
                        $datspr = $decodiraniPodatki['datspr'];

                        // Update user to get user cookie in database
                        $uporabnik_arr = array(
                            "iduporabnika" => $id,
                            "idvloge" => "$idvloge",
                            "idcert" => "$idcert",
                            "email" => "$email",
                            "indmailpotrjen" => "$indmailpotrjen",
                            "geslo" => "$geslo",
                            "sol" => "$sol",
                            "piskotek" => "$value",
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

                    } else {

                        # Use users cookie
                        $name = "cookie";
                        $value = $decodiraniPodatki['piskotek'];
                        setcookie($name, $value, time() + 3200, "/");
                    }

                    # Logged in
                    ViewHelper::redirect('/');
                }
            }
        }
    }



    public static function generateRandomString($length = 32) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}