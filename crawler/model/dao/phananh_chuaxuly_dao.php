<?php
require_once dirname(__FILE__, 2) . "/dto/phananh_chuaxuly.php";

class phananh_chuaxuly_dao
{
  private $phananh, $conn;

  /** 
   * check if the the particular-id "phananh" was loaded and saved to database before 
   * If it 's existing in database, meaning that the "phananh_chuaxuly" is old (this function return false)
   * Else, return true
   */
  private function check_phananh_is_new()
  { }
}