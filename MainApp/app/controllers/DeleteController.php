<?php

require_once "ViewHelper.php";
require_once "requestUtil.php";
require_once "app/controllers/GetDataController.php";

class DeleteController {

    public static function deleteUser($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();
            $deleteUporabnik = GetDataController::getUserId($id);

            if(($uporabnik['idvloge'] == 'A' && ($deleteUporabnik['idvloge'] == 'P' || $deleteUporabnik['idvloge'] == 'S'))
                || $uporabnik['idvloge'] == 'P' && $deleteUporabnik['idvloge'] == 'S') {

                $user_arr = array(
                    "iduporabnika"=>$id
                );

                requestUtil::sendRequestDELETE('http://localhost/trgovina/api/v1/uporabniki/delete.php', "DELETE", $user_arr);

                if($uporabnik['idvloge'] == 'P') {
                    ViewHelper::redirect(ROOT_URL . 'prodajalec');
                } else if($uporabnik['idvloge'] == 'A') {
                    ViewHelper::redirect(ROOT_URL . 'admin');
                }
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Nimate dovoljenja za izvedbo te akcije!</h3>";
            echo "Nazaj na <a href=\""; echo ROOT_URL; echo"\">prvo stran</ahref>";
        }
    }

    public static function deleteArtikel($metho, $id) {
        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();

            if($uporabnik['idvloge'] == 'A' || $uporabnik['idvloge'] == 'P') {

                $art_arr = array(
                    "idartikla"=>$id
                );

                requestUtil::sendRequestDELETE('http://localhost/trgovina/api/v1/artikli/delete.php', "DELETE", $art_arr);

                if($uporabnik['idvloge'] == 'P') {
                    ViewHelper::redirect(ROOT_URL . 'prodajalec');
                } else if($uporabnik['idvloge'] == 'A') {
                    ViewHelper::redirect(ROOT_URL . 'admin');
                }
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Nimate dovoljenja za izvedbo te akcije!</h3>";
            echo "Nazaj na <a href=\""; echo ROOT_URL; echo"\">prvo stran</ahref>";
        }
    }
}