<?php
/**
 * Created by PhpStorm.
 * User: aleksandarhristov
 * Date: 3.1.2019
 * Time: 19:20
 */

class requestUtil
{

  public static function sendRequest($url, $method, $body)
  {
    $options = array(
      'http' => array(
        'header' => "Content-Type: application/json\r\n",
        'method' => $method
        //'content' => http_build_query($body)
      )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result);
    return $result;
  }

}