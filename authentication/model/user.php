<?php

/** 
 * Although the "authentication",(which had been loaded from github :v), has completed the 
 * registering and login - log out feature. But we should create the "model" directory, with dto and dao file
 * so that we can do many things more with the users table
 */
class user
{
  public $id, $user_name;
  public $email, $hash_password, $passsword, $keywords, $reset_password_key;

  /**
   * Class constructor.
   * @param array $row it is return by mysqli_fetch_assoc function
   */
  public function __construct(array $row)
  {
    $this->id = $row['id'];
    $this->user_name = $row['user_name'];
    $this->email = $row['email'];
    $this->hash_password = $row['hash_password'];
    $this->passsword = $row['passsword'];
    $this->keywords = $row['keywords'];
    $this->reset_password_key = $row['reset_password_key'];
  }
}