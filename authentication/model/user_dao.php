<?php
require_once dirname(__FILE__, 3) . "/crawler/db_connector/db.php";
require_once dirname(__FILE__) . "/user.php";

/** 
 * Although the "authentication",(which had been loaded from github :v), has completed the 
 * registering and login - log out feature. But we should create the "model" directory, with dto and dao file
 * so that we can do many things more with the users table
 */
class user_dao
{
  private $db;
  /**
   * Class constructor.
   */
  public function __construct()
  {
    $db = new db();
    $this->db = $db->get_conn();
  }

  /** 
   * Get the keyword of the specified user 
   * @param user $user
   */
  public function get_keywords_of_user(user $user)
  {
    return $user->keywords;
  }


  /** 
   * Get the keyword of the specified user by its id
   * @param int $id of user
   * @param mixed $keywords. if keyword is null, the app will load keyword from database
   */
  public function get_keywords_of_user_by_id(int $id, $keywords = null)
  {
    if (isset($keywords)) {
      return json_decode($keywords, true);
    } else {
      $SQL = "Select keywords from users where id = " . $id;
      $result = $this->db->query($SQL);
      $returned_result = [];
      $row = $result->fetch_assoc();
      $returned_result = json_decode($row, true);
      return $returned_result;
    }
  }

  /** 
   * Set new keywords for user 
   * @param int $id id of user
   * @param string $keywords $keywords which is set for user
   */
  public function set_keywords_for_user(int $id, string $keywords)
  {
    $SQL = "Update users set keywords = ? where id = ?";
    $stmt = $this->db->prepare($SQL);
    $stmt->bind_param("si", $keywords, $id);
    $stmt->execute();
  }

  /** 
   * Set the reset_password key for specified user: Save it to database, and return it as string
   * @param user $user which is asking for reset password.
   */
  public function set_reset_password_key_for_user(user $user)
  {
    $hash_pass_enscript = md5($user->hash_password);
    $pass_enscript = md5($user->passsword);
    $key_enscript = md5($user->keywords);
    $reset_key = $hash_pass_enscript . $pass_enscript . $key_enscript;
    // Save the reset_key to database
    $SQL = "Update users set reset_password_key = ? where id = ?";
    $stmt = $this->db->prepare($SQL);
    $stmt->bind_param("si", $reset_key, $user->id);
    $stmt->execute();
    // THEN return
    return $reset_key;
  }

  /** 
   * Delete reset_key for user
   * @param user $user which is needed to delete reset_key.
   */
  public function delete_reset_password_key_for_user(user $user)
  {
    $SQL = "Update users set reset_password_key = ? where id = ?";
    $stmt = $this->db->prepare($SQL);
    $stmt->bind_param("si", "", $user->id);
    $stmt->execute();
  }
}