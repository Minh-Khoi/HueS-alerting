<?php
require_once dirname(__FILE__, 2) . "/libs/simple_html_dom.php";
require_once dirname(__FILE__, 2) . "/model/dao/phananh_chuaxuly_dao.php";
require_once dirname(__FILE__, 2) . "/model/dto/phananh_chuaxuly.php";
require_once dirname(__FILE__, 3) . "/authentication/model/user_dao.php";

class action
{
  private $url = "https://tuongtac.thuathienhue.gov.vn/?act=dxl",
    $url_page = "https://tuongtac.thuathienhue.gov.vn/?pa=";


  /**
   * Class constructor.
   */
  public function __construct()
  { }

  /** 
   * Scrape the webpage "tuongtac.thuathienhue.gov.vn/?act=dxl" and find out the id of
   * latest "phananh" object which was uploaded on website
   */
  public function find_max_index()
  {
    $str_page_dxl = file_get_contents($this->url);
    $html_page_dxl = str_get_html($str_page_dxl);
    $anchor_elements = $html_page_dxl->find("#PhanAnhDangXuLy1_divDanhSach .PhanAnhMoi_TieuDe a");
    // echo print_r($anchor_elements[0]->href, true); die();
    $href_of_anchor_element = $anchor_elements[0]->href;
    $id_of_anchor_element = (int) str_replace("?pa=", "", $href_of_anchor_element);
    return $id_of_anchor_element;
  }

  /**
   *  Find Keyword in page 
   * @param string $noidung the "nội dung phản anh" is stored in $phananh->noi_dung
   */
  public function having_right_keyword(string $noidung, array $keywords)
  {
    $noidung_upper = mb_strtoupper($noidung, "UTF-8");
    $keywords_existing = false;
    foreach ($keywords as $k => $words) {
      // echo "$words \t";
      // var_dump($noidung_upper);
      // var_dump(stripos($noidung_upper, trim($words)));
      // // echo "\n";
      if (stripos($noidung_upper, trim($words)) !== false) {
        $keywords_existing = true;
      }
    }
    return $keywords_existing;
  }

  /** 
   * Save new keywords list in json file, or ignore keywords if it was saved before (in json file)
   */
  public function check_for_storing_keywords(array $keywords_array)
  {
    $keywords_in_json_file = file_get_contents(dirname(__FILE__) . "./keywords_list.json");
    $keywords_in_json_file_to_upper = strtoupper($keywords_in_json_file);
    $arrayof_keywords_in_json_file = (array) json_decode($keywords_in_json_file);
    // var_dump($keywords_in_json_file);
    // die();
    foreach ($keywords_array as $k => $words) {
      // var_dump($words);
      if (!in_array(mb_strtoupper($words), $arrayof_keywords_in_json_file)) {
        array_push($arrayof_keywords_in_json_file, mb_strtoupper($words));
        // var_dump(json_encode($arrayof_keywords_in_json_file));
      };
      $json = json_encode($arrayof_keywords_in_json_file);
      // var_dump($json);
      file_put_contents(dirname(__FILE__) . "/keywords_list.json", $json);
    }
  }

  /** return the array of all keywords save in keywords_list.json */
  public function get_all_keywords()
  {
    $keywords_in_json_file = file_get_contents(dirname(__FILE__) . "/keywords_list.json");
    $array_of_keywords = (array) json_decode($keywords_in_json_file);
    // var_dump($array_of_keywords);
    // die();
    return $array_of_keywords;
  }

  /** 
   * add new keyword for login user. When this function is invoked, the server will replace the string in 
   * "keywords" field in database with the new string send from mobile app
   * @param string $new_keywords all keywords that the user want to search,
   * these keywords must include the keyword had been saved before
   * @param string $token_remembered the submitted form must include the login-remember token 
   * to invoke this method
   */
  public function add_new_keywords(string $new_keywords, string $token_remembered)
  {
    $user_dao = new user_dao();
    $user = $user_dao->find_user_by_token($token_remembered);
    if (is_null($user)) {
      echo "Post Form with invalid TOKEN";
      die();
    }
    $username = $user->user_name;
    if ($user_dao->set_keywords_for_user($username, $new_keywords)) {
      echo "Your keywords eywords have been successfully saved in to database";
    };
    $arrayof_new_keywords = explode('+', $new_keywords);
    $this->check_for_storing_keywords($arrayof_new_keywords);
  }

  /** 
   * validation the old password. If right change the password as required
   * @param string $old_pass @param string $new_pass @param string $new_retyped
   */
  public function change_password(
    string $old_pass,
    string $new_pass,
    string $new_retyped,
    string $token_remembered
  ) {
    $user_dao = new user_dao();
    $user = $user_dao->find_user_by_token($token_remembered);
    if (is_null($user)) {
      echo "Post Form with invalid TOKEN";
      die();
    }
    // var_dump($user->hashed_password);
    // var_dump(($old_pass));

    $valid_old_pass = md5($old_pass) === $user->hashed_password;
    if (!$valid_old_pass) {
      echo ('your current password is not correct!!!');
    } else if ($new_pass != $new_retyped) {
      echo ('your new password is not re-typed correctly !!');
    } else {
      $user_dao->set_password_for_user($user, $new_pass);
      echo "update password successfully";
    }
  }
}