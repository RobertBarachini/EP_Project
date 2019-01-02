<?php
  session_start();
  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT',dirname(__FILE__));
  //razdelimo Url na stringe po slashih
  $url = isset($_SERVER['PATH_INFO']) ? explode('/',ltrim($_SERVER['PATH_INFO'],'/')):[];
  require_once(ROOT . DS . 'core' . DS . 'bootstrap.php');