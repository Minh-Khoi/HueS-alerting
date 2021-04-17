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
   * get the instance of user class from database by according to username
   * @param string $username
   * @return user 
   */
  public function get_user_by_username(string $username)
  {
    $SQL = "Select * from users where user_name = '$username'";
    $result_set = $this->db->query($SQL);
    $result_array_of_users = [];
    while ($row = $result_set->fetch_assoc()) {
      $user = new user($row);
      array_push($result_array_of_users, $user);
    }
    return $result_array_of_users[0];
  }

  /**
   *  Check if a new user_name has been registered before 
   * @param string $username the username of the new registering user
   */
  public function username_existing(string $username)
  {
    $SQL = "Select * from users where user_name = '$username'";
    $result_set = $this->db->query($SQL);
    // var_dump($SQL);
    // die();
    if ($result_set->num_rows > 0) {
      return true;
    }
    return false;
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
      $SQL = "Select keywords from users where id = '" . $id . "'";
      $result = $this->db->query($SQL);
      $returned_result = [];
      $row = $result->fetch_assoc();
      $returned_result = json_decode($row, true);
      return $returned_result;
    }
  }

  /** 
   * Set new keywords for user 
   * @param string $username name of user
   * @param string $keywords $keywords which is set for user
   */
  public function set_keywords_for_user(string $username, string $keywords)
  {
    $SQL = "Update users set keywords = ? where user_name = ?";
    $stmt = $this->db->prepare($SQL);
    $stmt->bind_param("ss", $keywords, $username);
    return $stmt->execute();
  }

  /** Set new password for user */
  public function set_password_for_user(user $user, string $new_password)
  {
    $hashed_new_pass = md5($new_password);
    $SQL = "Update users set password = ?, hashed_password =? where user_name = ?";
    $stmt = $this->db->prepare($SQL);
    $stmt->bind_param("sss", $new_password, $hashed_new_pass, $user->user_name);
    $stmt->execute();
  }

  /** Save the logging-in  token in to database  */
  public function set_remember_login_token(string $token, string $username)
  {
    $SQL = "Update users set login_remembering_token = ? where user_name = ?";
    $stmt = $this->db->prepare($SQL);
    $stmt->bind_param("ss", $token, $username);
    $stmt->execute();
  }

  public function get_remember_login_token(string $username)
  {
    $SQL = "Select keywords from users where user_name = '$username'";
    $result = $this->db->query($SQL);
    $returned_result = [];
    $row = $result->fetch_assoc();
    $returned_result = json_decode($row, true);
  }

  /**
   *  Check if the remembered token is valid is owned by user,
   * @param string $token
   * @return user $user the user whose the $token or NULL
   */
  public function find_user_by_token(string $token)
  {
    $query = "SELECT * FROM users WHERE login_remembering_token = '$token'";
    $data_response_object = [];
    $result_set = $this->db->query($query);
    $row_of_user = $result_set->fetch_assoc();
    if ($result_set->num_rows == 0) {
      return null;
    }
    $user = new user($row_of_user);
    return $user;
  }
}
