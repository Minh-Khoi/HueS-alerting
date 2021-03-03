<?php

/** 
 * Although the "authentication",(which had been loaded from github :v), has completed the 
 * registering and login - log out feature. But we should create the "model" directory, with dto and dao file
 * so that we can do many things more with the users table
 */

class user
{
  private $id, $user_name;
  public $email, $hash_password, $passsword, $keywords;
  /**
   * Class constructor.
   */
  public function __construct($id, $user_name, $email, $hash_password, $passsword, $keywords)
  {
    $this->id = $id;
    $this->user_name = $user_name;
    $this->email = $email;
    $this->hash_password = $hash_password;
    $this->passsword = $passsword;
    $this->keywords = $keywords;
  }
}