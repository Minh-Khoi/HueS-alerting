<?php
require_once dirname(__FILE__, 2) . "/dto/phananh_chuaxuly.php";
require_once dirname(__FILE__, 3) . "/db_connector/db.php";

class phananh_chuaxuly_dao
{
  private $phananh, $conn;
  private $SQL_INSERT = "Insert into phananh_chua_xuly values (?,?,?,?,?,?,?)",
    $SQL_SELECT = "Select * from phananh_chua_xuly ",
    $SQL_UPDATE_DA_XEM = "Update phananh_chua_xuly SET da_xem = '?' WHERE id = '?' ",
    $SQL_DELETE = "Delete from phananh_chua_xuly where id = '?'";

  /**
   * Class constructor.
   */
  public function __construct()
  {
    $db =  new db();
    $this->conn = $db->get_conn();
  }

  /** 
   * check if the the particular-id "phananh" was loaded and saved to database before 
   * If it 's existing in database, meaning that the "phananh_chuaxuly" is old (this function return false)
   * Else, return true
   * @param $id is index of the web-page showing the corresponding "phananh"
   */
  private function checkif_phananh_is_new(int $id)
  {
    $SQL_SELECT = "Select * from phananh_chua_xuly where id = ?";
    $result = $this->conn->query($SQL_SELECT);
    return ($result->num_rows == 0);
  }
}