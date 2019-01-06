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

                if($hashedPassword != $expectedPassword) {
                    ViewHelper::redirect('/login?login=wrongAuthentication');
                } else {

                    // TO-DO Cookies
                }
            }
        }
    }
}