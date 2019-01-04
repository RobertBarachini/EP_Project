<?php

require_once "app/controllers/IndexController.php";
require_once "app/controllers/ArtikelController.php";

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
      "/^druga$/" => function() {
        echo "druga";
      }
    ];
  }
}