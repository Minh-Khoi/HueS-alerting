<?php
require_once dirname(__FILE__, 2) . "/libs/simple_html_dom.php";
require_once dirname(__FILE__, 2) . "/model/dao/phananh_chuaxuly_dao.php";
require_once dirname(__FILE__, 2) . "/model/dto/phananh_chuaxuly.php";

class action
{
  private $url = "https://tuongtac.thuathienhue.gov.vn/?act=dxl";

  /** 
   * Scrape the webpage "tuongtac.thuathienhue.gov.vn/?act=dxl" and find out the id of
   * latest "phananh" object which was uploaded on website
   */
  public function find_max_index()
  {
    $html_page_dxl = file_get_html($this->url);
    $anchor_elements = $html_page_dxl->find(".PhanAnhTB_Nen .PhanAnhTB_Dong .PhanAnhTB_TieuDe a");
    $href_of_anchor_element = $anchor_elements[0]->href;
    $id_of_anchor_element = (int) str_replace("?pa=", "", $href_of_anchor_element);
    return $id_of_anchor_element;
  }
}