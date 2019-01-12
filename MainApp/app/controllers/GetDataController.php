<?php
/**
 * Created by PhpStorm.
 * User: jvrhunc
 * Date: 10.1.2019
 * Time: 3:32
 */

class GetDataController {

    public static function getUser() {
        $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php'  . '?piskotek=' . $_COOKIE['cookie'], "GET", "");
        $berljiviPodatki = json_encode($uporabnik);
        $decodiraniPodatki = json_decode($berljiviPodatki,true);
        return $decodiraniPodatki;
    }

    public static function getUserId($id) {
        $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one.php'  . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnik);
        $decodiraniPodatki = json_decode($berljiviPodatki,true);
        return $decodiraniPodatki;
    }

    public static function getArtikelId($id) {
        $artikel = requestUtil::sendRequest('http://localhost/trgovina/api/v1/artikli/read_one.php'  . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($artikel);
        $decodiraniPodatki = json_decode($berljiviPodatki,true);
        return $decodiraniPodatki;
    }

    public static function getSlika($artikel) {
        $slikeArray = array();
        $artikli_slike = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli_slike/read.php", "GET", "");
        $berljiviPodatki_slike = json_encode($artikli_slike);
        $decod = json_decode($berljiviPodatki_slike, true);
        $artikli_slike_P = $decod['body'];

        foreach ($artikli_slike_P as $key => $val) {
            if ($val['idartikla'] == $artikel['idartikla']) {
                array_push($slikeArray, $val);
                break;
            }
        }

        return $slikeArray;
    }
}