<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 10.1.2019
 * Time: 0:33
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";

class AdminController {

    public static function showAdminConsole() {

        $uporabniki = requestUtil::sendRequest("http://localhost/trgovina/api/v1/uporabniki/read.php","GET","");
        $berljiviPodatki = json_encode($uporabniki);
        $decodiraniPodatki = json_decode($berljiviPodatki,true);
        $podatki = $decodiraniPodatki['body'];

        echo ViewHelper::render("app/views/admin/admin.php", ["uporabniki"=>$podatki]);
    }

    public static function showDodajProdajalca() {
        echo ViewHelper::render("app/views/admin/dodajProdajalca.php", []);
    }

    public static function dodajProdajalca($uporabnik, $post) {
        $ime = $post['ime'];
        $priimek = $post['priimek'];
        $ulica = $post['ulica'];
        $kraj = $post['kraj'];
        $posta = $post['posta'];
        $drzava = $post['drzava'];
        $email = $post['email'];
        $geslo = $post['geslo'];


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
                        "idvloge" => "P",
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
                    ViewHelper::redirect('/admin');
                }
            }
        }
    }
}