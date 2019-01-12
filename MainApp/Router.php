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
require_once "app/controllers/DeleteController.php";
require_once "app/controllers/NarocilaController.php";


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
      "/^admin\/seller\/add$/" => function() {
        AdminController::showDodajProdajalca();
      },
      "/^admin\/seller\/(\d+)$/" => function($method, $id) {
        AdminController::showPodrobnostiProdajalca($method, $id);
      },
      "/^admin\/seller\/(\d+)\/edit$/" => function($method, $id) {
        AdminController::showEditProdajalca($method, $id);
      },
      "/^deactivate\/admin\/(\d+)$/" => function($method, $id) {
        AdminController::deactivate($method, $id);
      },
      "/^activate\/admin\/(\d+)$/" => function($method, $id) {
        AdminController::activate($method, $id);
      },
      "/^prodajalec$/" => function() {
        ProdajalecController::showProdajalecConsole();
      },
      "/^deactivate\/customer\/(\d+)$/" => function($method, $id) {
        ProdajalecController::deactivate($method, $id);
      },
      "/^activate\/customer\/(\d+)$/" => function($method, $id) {
        ProdajalecController::activate($method, $id);
      },
      "/^deactivate\/artikel\/(\d+)$/" => function($method, $id) {
        ProdajalecController::deactivateArtikel($method, $id);
      },
      "/^activate\/artikel\/(\d+)$/" => function($method, $id) {
        ProdajalecController::activateArtikel($method, $id);
      },
      "/^prodajalec\/customer\/add$/" => function() {
        ProdajalecController::showAddCustomer();
      },
      "/^prodajalec\/artikel\/add$/" => function() {
        ProdajalecController::showAddArtikel();
      },
      "/^prodajalec\/artikel\/(\d+)\/imageAdd$/" => function($method, $id) {
        ProdajalecController::showImageAdd($method, $id);
      },
      "/^prodajalec\/customer\/(\d+)$/" => function($method, $id) {
        ProdajalecController::showCustomerDetails($method, $id);
      },
      "/^prodajalec\/customer\/(\d+)\/edit$/" => function($method, $id) {
        ProdajalecController::showEditCustomerDetails($method, $id);
      },
      "/^prodajalec\/artikel\/(\d+)$/" => function($method, $id) {
        ProdajalecController::showArtikelDetails($method, $id);
      },
      "/^prodajalec\/artikel\/(\d+)\/edit$/" => function($method, $id) {
        ProdajalecController::showEditArtikelDetails($method, $id);
      },
      "/^user\/(\d+)\/delete$/" => function($method, $id) {
        DeleteController::deleteUser($method, $id);
      },
      "/^artikel\/(\d+)\/delete$/" => function($method, $id) {
        DeleteController::deleteArtikel($method, $id);
      },
      "/^prodajalec\/narocila$/" => function() {
        NarocilaController::showNarocila();
      },
      "/^narocila\/(\d+)\/accept$/" => function($method, $id) {
        NarocilaController::acceptNarocilo($method, $id);
      },
      "/^narocila\/(\d+)\/decline$/" => function($method, $id) {
        NarocilaController::declineNarocilo($method, $id);
      },
      "/^prodajalec\/narocila\/(\d+)$/" => function($method, $id) {
        NarocilaController::showNarociloDetails($method, $id);
      },
      "/^druga$/" => function() {
        echo "druga";
      }
    ];
  }
}