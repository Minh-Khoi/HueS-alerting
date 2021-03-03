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
}