<?php
require_once dirname(__FILE__, 2) . "/url.php";
require_once dirname(__FILE__, 3) . "/libs/simple_html_dom.php";


class phananh_chuaxuly
{
  public $id, $link, $noi_dung, $ngay_update, $donvi_xuly, $thoi_han, $is_new;
  private $url;

  /**
   * Class model dto constructor.
   */
  public function __construct(int $id)
  {
    $this->id = $id;
    $this->link = "https://tuongtac.thuathienhue.gov.vn/?pa=" . $id;
    $this->set_url();
    $this->crawl_by_index();
  }

  /** 
   * Scrape all the details of one phananh object by $this->id
   */
  private function crawl_by_index()
  {
    $html = file_get_html($this->url);
    // Write the code below to set value for variables $noi_dung, $ngay_update, $donvi_xuly, $thoi_han,
    // $ket_qua, $da_xem ..... (The work checking if phananh is solved or not must be done 
    // before a "phananh_chuaxualy" is constructed!)
    $this->noi_dung = $html->find(".ChiTiet_Vien .ChiTiet_NoiDung")[0]->innertext;
    $this->ngay_update = $html->find(".ChiTiet_Vien .ChiTiet_NgayGui")[0]->innertext;
    $this->thoi_han = $html->find(".ChiTiet_Vien .ChiTiet_NgayGui")[1]->innertext;
    $this->donvi_xuly = $html->find(".ChiTiet_Vien .ChiTiet_XuLy_Vien .ChiTiet_DonVi")[0]->innertext;
    $this->is_new = $this->check_phananh_is_new();
    // Write te code below to save the oldest index of phananh_chuaxuly...


  }

  /** Set and return value of "$this->url", which is the url link to the web page of "phananh_chuaxuly" */
  private function get_url()
  {
    $url_object = new url_object();
    $this->url = $url_object->url . "?pa=" . $this->id;
  }

  /** 
   * check if the the particular-id "phananh" was loaded and saved to database before 
   * If it 's existing in database, meaning that the "phananh_chuaxuly" is old (this function return false)
   * Else, return true
   */
  private function check_phananh_is_new()
  { }
}