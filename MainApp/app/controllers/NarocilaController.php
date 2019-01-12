<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 12.1.2019
 * Time: 3:09
 */

require_once "ViewHelper.php";
require_once "requestUtil.php";

class NarocilaController {

    public static function showNarocila() {
        $narocilaT = requestUtil::sendRequest("http://localhost/trgovina/api/v1/narocila/read.php", "GET", "");
        $berljiviPodatki = json_encode($narocilaT);
        $narocila = json_decode($berljiviPodatki, true);
        $podatki = $narocila['body'];

        echo ViewHelper::render("app/views/prodajalec/narocila.php",["narocila" => $podatki]);
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

        $slikeArray = array();
        $artikli_slike = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli_slike/read.php", "GET", "");
        $berljiviPodatki_slike = json_encode($artikli_slike);
        $decod = json_decode($berljiviPodatki_slike, true);
        $artikli_slike_P = $decod['body'];

        echo ViewHelper::render("app/views/prodajalec/narocilaDetail.php",["narocilo" => $narocilo, "uporabnik" => $uporabnik, "narArt" => $artikli]);
    }

    public static function acceptNarocilo($method, $id) {
        // TO-DO
    }

    public static function declineNarocilo($method, $id) {
        // TO-DO
    }

}