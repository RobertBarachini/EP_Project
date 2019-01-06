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

    public static function preveriVnose($ime, $priimek, $ulica,
                                        $kraj, $posta, $drzava,
                                        $email, $geslo) {

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
                    $hashedPassword = password_hash($geslo, PASSWORD_DEFAULT);

                    $uporabnik_arr = array(
                        "idvloge" => "",
                        "idcert" => "",
                        "email" => "$email",
                        "indmailpotrjen" => "",
                        "geslo" => "$hashedPassword",
                        "piskotek" => "",
                        "ime" => "$ime",
                        "priimek" => "$priimek",
                        "ulica" => "$ulica",
                        "posta" => "$posta",
                        "kraj" => "$kraj",
                        "drzava" => "$drzava",
                        "idspr" => "",
                        "datprijave" => "",
                        "status" => "",
                        "datspr" => ""
                    );

                    $temp = requestUtil::sendRequestPOST("http://localhost/trgovina/api/v1/uporabniki/create.php","POST",$uporabnik_arr);
                    //var_dump($temp);
                }
            }
        }
    }
}