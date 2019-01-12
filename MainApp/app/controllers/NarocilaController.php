<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 12.1.2019
 * Time: 3:09
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";
require_once "app/controllers/GetDataController.php";

error_reporting(E_ALL & ~E_WARNING);

class NarocilaController {

    public static function showNarocila() {
        $narocilaT = requestUtil::sendRequest("http://localhost/trgovina/api/v1/narocila/read.php", "GET", "");
        $berljiviPodatki = json_encode($narocilaT);
        $narocila = json_decode($berljiviPodatki, true);
        $podatki = $narocila['body'];

        echo ViewHelper::render("app/views/prodajalec/narocila.php",["narocila" => $podatki]);
    }

    public static function showZgo() {
        $narocilaT = requestUtil::sendRequest("http://localhost/trgovina/api/v1/narocila/read.php", "GET", "");
        $berljiviPodatki = json_encode($narocilaT);
        $narocila = json_decode($berljiviPodatki, true);
        $podatki = $narocila['body'];

        echo ViewHelper::render("app/views/prodajalec/narocilaZgo.php",["naroc" => $podatki]);
    }

    public static function showNarociloDetails($method, $id) {
        $narociloT = requestUtil::sendRequest("http://localhost/trgovina/api/v1/narocila/read_one.php" . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($narociloT);
        $narocilo = json_decode($berljiviPodatki, true);

        $iduporabnika = $narocilo['iduporabnika'];
        $uporabnikT = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $iduporabnika, "GET", "");
        $berljiviPodatkiU = json_encode($uporabnikT);
        $uporabnik = json_decode($berljiviPodatkiU, true);

        $artikliNarocila = requestUtil::sendRequest("http://localhost//trgovina/api/v1/narocila_artikli/read.php", "GET", "");
        $berljiviPodatkiAN = json_encode($artikliNarocila);
        $artikliT = json_decode($berljiviPodatkiAN, true);
        $podatki = $artikliT['body'];

        $artikli = array();

        foreach ($podatki as $key => $art) {
            if ($art['idnarocila'] == $id) {
                array_push($artikli, $art);
            }
        }

        echo ViewHelper::render("app/views/prodajalec/narocilaDetail.php",["narocilo" => $narocilo, "uporabnik" => $uporabnik, "narArt" => $artikli]);
    }

    public static function acceptNarocilo($method, $id) {
        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();
            if($uporabnik['idvloge'] == 'P') {
                $narociloT = requestUtil::sendRequest("http://localhost/trgovina/api/v1/narocila/read_one.php" . '?id=' . $id, "GET", "");
                $berljiviPodatki = json_encode($narociloT);
                $narocilo = json_decode($berljiviPodatki, true);

                $iduporabnika = $narocilo['iduporabnika'];
                $datzac_kosarice = $narocilo['datzac_kosarice'];
                $datnarocila = $narocilo['datnarocila'];
                $datposiljanja = $narocilo['datposiljanja'];
                $faza = 'P';
                $status = $narocilo['status'];
                $idspr = $narocilo['idspr'];

                $narocilo_arr = array(
                    "idnarocila"=> $id,
                    "iduporabnika"=> $iduporabnika,
                    "datzac_kosarice"=> $datzac_kosarice,
                    "datnarocila"=> $datnarocila,
                    "datposiljanja"=> $datposiljanja,
                    "faza"=> $faza,
                    "status"=> $status,
                    "datspr"=> date("Y-m-d H:i:s"),
                    "idspr"=> $idspr
                );

                requestUtil::sendRequestPUT("http://localhost/trgovina/api/v1/narocila/update.php", "PUT", $narocilo_arr);
                ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'narocila');
            } else {
                echo "<h3 style='margin-left: 20px' >Za dostop do funkcionalnosti je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do funkcionalnosti je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function declineNarocilo($method, $id) {
        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();
            if($uporabnik['idvloge'] == 'P') {
                $narociloT = requestUtil::sendRequest("http://localhost/trgovina/api/v1/narocila/read_one.php" . '?id=' . $id, "GET", "");
                $berljiviPodatki = json_encode($narociloT);
                $narocilo = json_decode($berljiviPodatki, true);

                $iduporabnika = $narocilo['iduporabnika'];
                $datzac_kosarice = $narocilo['datzac_kosarice'];
                $datnarocila = $narocilo['datnarocila'];
                $datposiljanja = $narocilo['datposiljanja'];
                $faza = 'Z';
                $status = $narocilo['status'];
                $idspr = $narocilo['idspr'];

                $narocilo_arr = array(
                    "idnarocila"=> $id,
                    "iduporabnika"=> $iduporabnika,
                    "datzac_kosarice"=> $datzac_kosarice,
                    "datnarocila"=> $datnarocila,
                    "datposiljanja"=> $datposiljanja,
                    "faza"=> $faza,
                    "status"=> $status,
                    "datspr"=> date("Y-m-d H:i:s"),
                    "idspr"=> $idspr
                );

                requestUtil::sendRequestPUT("http://localhost/trgovina/api/v1/narocila/update.php", "PUT", $narocilo_arr);
                ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'narocila');
            } else {
                echo "<h3 style='margin-left: 20px' >Za dostop do funkcionalnosti je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do funkcionalnosti je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function stornirajNarocilo($method, $id) {
        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();
            if($uporabnik['idvloge'] == 'P') {
                $narociloT = requestUtil::sendRequest("http://localhost/trgovina/api/v1/narocila/read_one.php" . '?id=' . $id, "GET", "");
                $berljiviPodatki = json_encode($narociloT);
                $narocilo = json_decode($berljiviPodatki, true);

                $iduporabnika = $narocilo['iduporabnika'];
                $datzac_kosarice = $narocilo['datzac_kosarice'];
                $datnarocila = $narocilo['datnarocila'];
                $datposiljanja = $narocilo['datposiljanja'];
                $faza = 'S';
                $status = $narocilo['status'];
                $idspr = $narocilo['idspr'];

                $narocilo_arr = array(
                    "idnarocila"=> $id,
                    "iduporabnika"=> $iduporabnika,
                    "datzac_kosarice"=> $datzac_kosarice,
                    "datnarocila"=> $datnarocila,
                    "datposiljanja"=> $datposiljanja,
                    "faza"=> $faza,
                    "status"=> $status,
                    "datspr"=> date("Y-m-d H:i:s"),
                    "idspr"=> $idspr
                );

                requestUtil::sendRequestPUT("http://localhost/trgovina/api/v1/narocila/update.php", "PUT", $narocilo_arr);
                ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'narocila' . DS . 'zgodovina');
            } else {
                echo "<h3 style='margin-left: 20px' >Za dostop do funkcionalnosti je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do funkcionalnosti je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

}