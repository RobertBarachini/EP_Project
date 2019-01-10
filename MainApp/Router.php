<?php

require_once "app/controllers/IndexController.php";
require_once "app/controllers/ArtikelController.php";
require_once "app/controllers/RegisterController.php";
require_once "app/controllers/LoginController.php";
require_once "app/controllers/KosaricaController.php";
require_once "app/controllers/CheckoutController.php";
require_once "app/controllers/ProdajalecController.php";
require_once "app/controllers/ProfilController.php";
require_once "app/controllers/LogoutController.php";
require_once "app/controllers/AdminController.php";


class Router
{

  public static function handleRouters($path)
  {
    foreach(self::getUrls() as $pattern => $controller) {

      if(preg_match($pattern,$path,$params)) {
        try{
          $params[0]  = $_SERVER["REQUEST_METHOD"];
          $controller(...$params);
        } catch(InvalidArgumentException $iae) {
            echo "404";
        } catch (Exception $e) {
            echo "exception";
        }
        exit();
      }
    }
  }

  private static function getUrls() {
    return [
      "/^$/" => function() {
        IndexController::indexPage();
      },
      "/^artikli\/(\d+)$/" => function($method, $id) {
        ArtikelController::artikelPage($id);
      },
      "/^register$/" => function() {
        RegisterController::registerUser();
      },
      "/^login$/" => function() {
        LoginController::loginUser();
      },
      "/^logout$/" => function() {
        LogoutController::logout();
      },
      "/^uporabniki\/(\d+)\/kosarica$/" => function($method, $id) {
        KosaricaController::kosaricaPage($id);
      },
      "/^uporabniki\/(\d+)\/checkout\/(\d+)$/" => function($method, $id1,$id2) {
        CheckoutController::checkoutPage($id1,$id2);
      },
      "/^PRODAJALEC$/" => function() {
        ProdajalecController::prodajalec();
      },
      "/^profil$/" => function() {
        ProfilController::showProfil();
      },
      "/^profil\/edit$/" => function() {
        ProfilController::showEdit();
      },
      "/^profil\/edit\/password$/" => function() {
        ProfilController::showEditPassword();
      },
      "/^admin$/" => function() {
        AdminController::showAdminConsole();
      },
      "/^druga$/" => function() {
        echo "druga";
      }
    ];
  }
}