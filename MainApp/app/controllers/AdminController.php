<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 10.1.2019
 * Time: 0:33
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";
require_once "app/controllers/GetDataController.php";

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

    public static function showPodrobnostiProdajalca($method, $id) {
        $uporabnik = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnik);
        $decodiraniPodatki = json_decode($berljiviPodatki, true);

        echo ViewHelper::render("app/views/admin/podrobnostiProdajalca.php", ["upor"=>$decodiraniPodatki]);
    }

    public static function showEditProdajalca($method, $id) {
        $uporabnik = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnik);
        $decodiraniPodatki = json_decode($berljiviPodatki, true);

        echo ViewHelper::render("app/views/admin/editPodatkiProdajalca.php", ["uporab"=>$decodiraniPodatki]);
    }

    public static function editProdajalec($uporabnik, $POST) {
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
        ViewHelper::redirect('/admin/seller' . DS . $id);
    }

    public static function dodajProdajalca($uporabnik, $post) {
        error_reporting(E_ALL & ~E_DEPRECATED);

        $ime = $post['ime'];
        $priimek = $post['priimek'];
        $ulica = $post['ulica'];
        $kraj = $post['kraj'];
        $posta = $post['posta'];
        $drzava = $post['drzava'];
        $email = $post['email'];
        $geslo = $post['geslo'];


        if(empty($ime) || empty($priimek) || empty($ulica)
            || empty($kraj) || empty($posta) || empty($drzava) || empty($geslo) || empty($email)) {
            echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Izpolnite vsa polja!
                                    </div>";
        } else {
            # Check if first and lastname are in correct form
            if(!preg_match("/^[a-zA-Z]*$/", $ime) || !preg_match("/^[a-zA-Z]*$/", $priimek)) {
                echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Ime in priimek lahko vsebujeta samo črke!
                                    </div>";
            } else {
                #Check if email is valid
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Elektronski naslov mora biti pravilne oblike (_@_._) 
                                    </div>";
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
                    $temp = requestUtil::sendRequestPOST("http://localhost/trgovina/api/v1/uporabniki/create.php","POST",$uporabnik_arr);

                    if($temp != "{\"id\":-1,\"message\":\"Unable to create object.\"}") {
                        echo "<div class=\"alert alert-success errorImg\">
                                        <strong>Prodajalec uspešno kreiran!</strong> 
                                        Nazaj na <a href='"; echo ROOT_URL . 'admin'; echo "'>admin konzolo</a> 
                                    </div>";
                    } else {
                        echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong>
                                    </div>";
                    }
                }
            }
        }
    }

    public static function deactivate($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnikA = GetDataController::getUser();
        }

        $uporabnikTmp = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikTmp);
        $uporabnik = json_decode($berljiviPodatki, true);

        if($uporabnikA['idvloge'] == 'A') {

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
            ViewHelper::redirect('/admin');
        } else {
            # User is not logged in and wants to access page profil/edit
            echo "<h3 style='margin-left: 20px' >Za dostop do admin konzole, je potrebna <a href='/login'>prijava</a> z administratorskim računom!</h3>";
        }
    }

    public static function activate($method, $id) {
        $uporabnikTmp = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikTmp);
        $uporabnik = json_decode($berljiviPodatki, true);

        if(isset($_COOKIE['cookie'])) {
            $uporabnikA = GetDataController::getUser();
        }

        if($uporabnikA['idvloge'] == 'A') {

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
            ViewHelper::redirect('/admin');
        } else {
            # User is not logged in and wants to access page profil/edit
            echo "<h3 style='margin-left: 20px' >Za dostop do admin konzole, je potrebna <a href='/login'>prijava</a> z administratorskim računom!</h3>";
        }
    }
}