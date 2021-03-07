<?php
require_once dirname(__FILE__, 2) . "/libs/simple_html_dom.php";
require_once dirname(__FILE__, 2) . "/model/dao/phananh_chuaxuly_dao.php";
require_once dirname(__FILE__, 2) . "/model/dto/phananh_chuaxuly.php";

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
    foreach ($keywords as $k => $words) {
      $array_of_keywords = explode("+", $words);
      $all_keywords_existing = true;
      foreach ($array_of_keywords as $k2 => $words2) {
        if (strpos($noidung, $words2) === false) {
          $all_keywords_existing = false;
          break;
        }
      }

      return $all_keywords_existing;
    }
    return false;
  }

  /** 
   * Save new keywords list in json file, or ignore keywords if it was saved before (in json file)
   */
  public function check_for_storing_keywords(array $keywords_array)
  {
    $keywords_in_json_file = file_get_contents('./keywords_list.json');
    $keywords_in_json_file_to_upper = strtoupper($keywords_in_json_file);
    $arrayof_keywords_in_json_file = json_decode($keywords_in_json_file);
    foreach ($keywords_array as $k => $words) {
      if (!in_array(strtoupper($words), $arrayof_keywords_in_json_file)) {
        array_push($arrayof_keywords_in_json_file, strtoupper($words));
        file_put_contents("./keywords_list.json", json_encode($arrayof_keywords_in_json_file));
      }
    }
  }

  /** return the array of all keywords save in keywords_list.json */
  public function get_all_keywords()
  {
    $keywords_in_json_file = file_get_contents(__DIR__ . "/keywords_list.json");
    $array_of_keywords = json_decode($keywords_in_json_file, true);
    return $array_of_keywords;
  }
}