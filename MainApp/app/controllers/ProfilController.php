<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 7.1.2019
 * Time: 0:39
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";

class ProfilController {

    public static function showProfil() {
        echo ViewHelper::render("app/views/profil/profil.php", []);
    }

    public static function showEdit() {
        echo ViewHelper::render("app/views/profil/edit/edit.php", []);
    }

    public static function showEditPassword() {
        echo ViewHelper::render("app/views/profil/edit/password.php", []);
    }

    public static function editProfil($uporabnik, $POST) {
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

        var_dump($uporabnik);

        var_dump($uporabnik_arr);

        # Update user
        requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/uporabniki/update.php', "PUT", $uporabnik_arr);
        ViewHelper::redirect('/profil');
    }

    public static function changePassword($POST) {
        # Get uporabnik by cookie value
        $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php'  . '?piskotek=' . $_COOKIE['cookie'], "GET", "");

        if($uporabnik == null ){
            # Handle exception -> unknown user

        } else {
            $berljiviPodatki = json_encode($uporabnik);
            $decodiraniPodatki = json_decode($berljiviPodatki,true);

            $checkOld = self::checkOldPassword($decodiraniPodatki, $POST['staro']);

            if($checkOld) {
                if(self::checkIfNewMatches($POST['novo1'], $POST['novo2'])) {
                    $novoGeslo = $POST['novo1'];
                    $salt = $decodiraniPodatki['sol'];
                    $hpwd = password_hash($novoGeslo, PASSWORD_DEFAULT, ['salt' => $salt]);
                    $hashedPassword = password_hash($hpwd . $salt, PASSWORD_DEFAULT, ['salt' => $salt]);

                    self::updatePassword($decodiraniPodatki, $hashedPassword);
                    ViewHelper::redirect('/profil');

                } else {
                    #Handle exception -> new password doesn't match
                }
            } else {
                # Handle exception -> wrong old password
            }

        }

    }

    public static function checkOldPassword($uporabnik, $geslo) {
        $salt = $uporabnik['sol'];
        $hpwd = password_hash($geslo, PASSWORD_DEFAULT, ['salt' => $salt]);
        $hashedPassword = password_hash($hpwd . $salt, PASSWORD_DEFAULT, ['salt' => $salt]);

        if($hashedPassword == $uporabnik['geslo']) {
            # Correct password
            return true;
        } else {
            # Wrong old password
            return false;
        }
    }

    public static function checkIfNewMatches($geslo1, $geslo2) {
        if($geslo1 == $geslo2) {
            return true;
        }
        return false;
    }

    public static function updatePassword($decodiraniPodatki, $hashedPassword) {
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
        ViewHelper::redirect('/profil');
    }
}