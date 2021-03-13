<?php

/** 
 * The IP of mobile device will be sent to server
 */
class client_device
{
  public $client_ip, $remember_login;
  /**
   * Class constructor.
   */
  public function __construct()
  {
    $this->client_ip = $this->save_client_ip();
  }

  /** Function to get the client IP address */
  private function save_client_ip()
  {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

  /**
   *  function to check if a device if it's was registered a remember-login token before
   * and assign its value to variable $remember_login
   * @param string $token_from_client
   */
  private function save_remember_login_token(string $token_from_client)
  { }
}
