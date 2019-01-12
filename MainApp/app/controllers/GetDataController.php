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
}