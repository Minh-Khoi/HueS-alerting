<?php
require_once dirname(__FILE__, 2) . "/dto/phananh_chuaxuly.php";
require_once dirname(__FILE__, 3) . "/db_connector/db.php";

class phananh_chuaxuly_dao
{
  private $phananh, $conn;
  private
    $SQL_INSERT = "Insert into phananh_chua_xuly values (?,?,?,?,?,?)",
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
   * @param phananh_chuaxuly $phananh
   */
  public function checkif_phananh_is_new(int $id)
  {
    // $id = $phananh->id;
    $SQL_SELECT = "Select * from phananh_chua_xuly where id = " . $id;
    $result = $this->conn->query($SQL_SELECT);
    return ($result->num_rows == 0);
  }

  /** 
   * Create a "phananh" object
   */
  public function create(phananh_chuaxuly $phananh)
  {
    $SQL_INSERT = "Insert into phananh_chua_xuly values (?,?,?,?,?,?,?)";
    $stmt = $this->conn->prepare($SQL_INSERT);
    $stmt->bind_param(
      "issssi",
      $phananh->id,
      $phananh->noi_dung,
      $phananh->ngay_update,
      $phananh->donvi_xuly,
      $phananh->thoi_han,
      ($phananh->is_new) ? 0 : 1
    );
    $stmt->execute();
  }

  /** Read all the "phananh" object saved in database */
  public function read_all()
  {
    $SQL_SELECT = "Select * from phananh_chua_xuly ";
    $result = $this->conn->query($SQL_SELECT);
    $array = [];
    while ($row = $result->fetch_assoc()) {
      array_push($array, $row);
    }
    return $array;
  }

  /** 
   * Read all the "phananh" object saved in database 
   * which have the {$value} on the column {$name_of_col} in database table
   */
  public function read_by_column(string $name_of_col, $value)
  {
    $SQL_SELECT = "Select * from phananh_chua_xuly where {$name_of_col} = " . $value;
    $result = $this->conn->query($SQL_SELECT);
    $array = [];
    while ($row = $result->fetch_assoc()) {
      array_push($array, $row);
    }
    return $array;
  }

  /** 
   * Change state of "phananh" object from "$da_xem=0" to '$da_xem = 1';
   * or we can change state of "phananh" become "$da_xem=0", by passing "0" value 
   * for the second parameter ($da_xem)
   */
  public function update_set_da_xem(int $id, int $da_xem = 1)
  {
    $SQL_UPDATE_DA_XEM = "Update phananh_chua_xuly SET da_xem = '?' WHERE id = '?' ";
    $stmt = $this->conn->prepare($SQL_UPDATE_DA_XEM);
    $stmt->bind_param("ii", $da_xem, $id);
    $stmt->execute();
  }


  /** 
   * Delete the specified-id "phananh" object
   */
  public function delete(int $id)
  {
    $SQL_DELETE = "Delete from phananh_chua_xuly where id = '?'";
    $stmt = $this->conn->prepare($SQL_DELETE);
    $stmt->bind_param("i", $id);
    $stmt->execute();
  }
}