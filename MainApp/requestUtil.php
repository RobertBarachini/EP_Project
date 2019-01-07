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
    try {
      $result = file_get_contents($url, false, $context);
      $result = json_decode($result);
      return $result;
    } catch (Exception $e) {
       var_dump($e);
    }
  }

  public static function sendRequestPOST($url, $method, $body)
  {
    $ch = curl_init();

    $body = json_encode($body);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json; charset=UTF-8'
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec($ch);

    curl_close($ch);

    return ($server_output);
  }

}