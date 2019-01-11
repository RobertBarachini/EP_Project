<?php

require_once "ViewHelper.php";
require_once "requestUtil.php";
require_once "app/controllers/GetDataController.php";

class ProdajalecController {

    public static function prodajalec() {
    echo ViewHelper::render("app/views/prodajalec/uploadPicture.php", []);
    }

    public static function showProdajalecConsole() {
      $uporabniki = requestUtil::sendRequest("http://localhost/trgovina/api/v1/uporabniki/read.php","GET","");
      $berljiviPodatki = json_encode($uporabniki);
      $decodiraniPodatki = json_decode($berljiviPodatki,true);
      $podatkiUsr = $decodiraniPodatki['body'];

      $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read.php","GET","");
      $berljiviPodatki = json_encode($artikli);
      $decodiraniPodatki = json_decode($berljiviPodatki,true);
      $podatkiArt = $decodiraniPodatki['body'];

      echo ViewHelper::render("app/views/prodajalec/prodajalec.php", ["stranke"=>$podatkiUsr, "artikli"=>$podatkiArt]);
    }

    public static function showAddCustomer() {
        echo ViewHelper::render("app/views/prodajalec/addCustomer.php", []);
    }

    public static function showAddArtikel() {
        echo ViewHelper::render("app/views/prodajalec/addArtikel.php", []);
    }

    public static function addCustomer($post) {
        $ime = $post['ime'];
        $priimek = $post['priimek'];
        $ulica = $post['ulica'];
        $kraj = $post['kraj'];
        $posta = $post['posta'];
        $drzava = $post['drzava'];
        $email = $post['email'];
        $geslo = $post['geslo'];

        # Check if there are empty fields
        if(empty($ime) || empty($priimek) || empty($ulica)
            || empty($kraj) || empty($posta) || empty($drzava) || empty($geslo)) {

        } else {
            # Check if first and lastname are in correct form
            if(!preg_match("/^[a-zA-Z]*$/", $ime) || !preg_match("/^[a-zA-Z]*$/", $priimek)) {

            } else {
                #Check if email is valid
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

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
                    ViewHelper::redirect('/prodajalec');
                }
            }
        }
    }

    public static function deactivate($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnikP = GetDataController::getUser();
        }

        $uporabnikTmp = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikTmp);
        $uporabnik = json_decode($berljiviPodatki, true);

        if($uporabnikP['idvloge'] == 'P') {

            $ime = $uporabnik['ime'];
            $priimek = $uporabnik['priimek'];
            $ulica = $uporabnik['ulica'];
            $kraj = $uporabnik['kraj'];
            $posta = $uporabnik['posta'];
            $drzava = $uporabnik['drzava'];
            $email = $uporabnik['email'];
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
            $status = "5";

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
            ViewHelper::redirect('/prodajalec');
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function activate($method, $id) {
        $uporabnikTmp = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikTmp);
        $uporabnik = json_decode($berljiviPodatki, true);

        if(isset($_COOKIE['cookie'])) {
            $uporabnikP = GetDataController::getUser();
        }

        if($uporabnikP['idvloge'] == 'P') {

            $ime = $uporabnik['ime'];
            $priimek = $uporabnik['priimek'];
            $ulica = $uporabnik['ulica'];
            $kraj = $uporabnik['kraj'];
            $posta = $uporabnik['posta'];
            $drzava = $uporabnik['drzava'];
            $email = $uporabnik['email'];
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
            $status = "0";

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
            ViewHelper::redirect('/prodajalec');
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function deactivateArtikel($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();

            if($uporabnik['idvloge'] == 'P') {
                $artikel = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
                $berljiviPodatki = json_encode($artikel);
                $decodiraniPodatki = json_decode($berljiviPodatki, true);

                $id = $decodiraniPodatki['idartikla'];
                $naziv = $decodiraniPodatki['naziv'];
                $opis = $decodiraniPodatki['opis'];
                $cena = $decodiraniPodatki['cena'];
                $st_ocen = $decodiraniPodatki['st_ocen'] == null ? "0" : $decodiraniPodatki['st_ocen'];
                $povprecna_ocena = $decodiraniPodatki['povprecna_ocena'] == null ? "1" : $decodiraniPodatki['povprecna_ocena'];
                $status = '5';
                $datspr = date("Y-m-d H:i:s");
                $idspr = $decodiraniPodatki['idspr'] == null ? "0" : $decodiraniPodatki['idspr'];

                $artikel_arr = array(
                    "idartikla" => $id,
                    "naziv" => $naziv,
                    "opis" => $opis,
                    "cena" => $cena,
                    "st_ocen" => $st_ocen,
                    "povprecna_ocena" => $povprecna_ocena,
                    "idspr" => "$idspr",
                    "datspr" => "$datspr",
                    "status" => "$status",
                );

                requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/artikli/update.php', "PUT", $artikel_arr);
                ViewHelper::redirect('/prodajalec');
            } else {
                echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function activateArtikel($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();

            if($uporabnik['idvloge'] == 'P') {
                $artikel = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
                $berljiviPodatki = json_encode($artikel);
                $decodiraniPodatki = json_decode($berljiviPodatki, true);

                $id = $decodiraniPodatki['idartikla'];
                $naziv = $decodiraniPodatki['naziv'];
                $opis = $decodiraniPodatki['opis'];
                $cena = $decodiraniPodatki['cena'];
                $st_ocen = $decodiraniPodatki['st_ocen'] == null ? "0" : $decodiraniPodatki['st_ocen'];
                $povprecna_ocena = $decodiraniPodatki['povprecna_ocena'] == null ? "1" : $decodiraniPodatki['povprecna_ocena'];
                $status = '0';
                $datspr = date("Y-m-d H:i:s");
                $idspr = $decodiraniPodatki['idspr'] == null ? "0" : $decodiraniPodatki['idspr'];

                $artikel_arr = array(
                    "idartikla" => $id,
                    "naziv" => $naziv,
                    "opis" => $opis,
                    "cena" => $cena,
                    "st_ocen" => $st_ocen,
                    "povprecna_ocena" => $povprecna_ocena,
                    "idspr" => "$idspr",
                    "datspr" => "$datspr",
                    "status" => "$status",
                );

                requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/artikli/update.php', "PUT", $artikel_arr);
                ViewHelper::redirect('/prodajalec');
            } else {
                echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

}