<?php
require_once dirname(__FILE__, 2) . "/url_object.php";
require_once dirname(__FILE__, 3) . "/libs/simple_html_dom.php";
require_once dirname(__FILE__, 2) . "/dao/phananh_chuaxuly_dao.php";


class phananh_chuaxuly
{
  public $id, $link, $noi_dung, $ngay_update, $donvi_xuly, $thoi_han, $is_new, $daxuly;
  private $url, $dao;

  /**
   * Class model dto constructor.
   */
  public function __construct(int $id)
  {
    $this->dao = new phananh_chuaxuly_dao();
    $this->id = $id;
    $this->link = "https://tuongtac.thuathienhue.gov.vn/?pa=" . $id;
    $this->get_url();
    $this->crawl_by_index();
  }

  /** 
   * Scrape all the details of one phananh object by $this->id
   */
  private function crawl_by_index()
  {
    $html = file_get_html($this->url);
    // if this "phananh" object has been "da_xu_ly", stop this function
    if ($this->da_xu_ly($html)) {
      $this->daxuly = true;
      return;
    }
    // Write the code below to set value for variables $noi_dung, $ngay_update, $donvi_xuly, $thoi_han,
    // $ket_qua, $is_new ..... (The work checking if phananh is solved or not must be done 
    // before a "phananh_chuaxualy" is constructed!)
    $this->noi_dung = $html->find(".ChiTiet_Vien .ChiTiet_NoiDung")[0]->innertext;
    $this->ngay_update = $html->find(".ChiTiet_Vien .ChiTiet_NgayGui")[0]->innertext;
    $this->thoi_han = $html->find(".ChiTiet_Vien .ChiTiet_NgayGui")[1]->innertext;
    $this->donvi_xuly = $html->find(".ChiTiet_Vien .ChiTiet_XuLy_Vien .ChiTiet_DonVi")[0]->innertext;
    $this->is_new = $this->dao->checkif_phananh_is_new($this->id);
  }

  /** Set and return value of "$this->url", which is the url link to the web page of "phananh_chuaxuly" */
  private function get_url()
  {
    $url_object = new url_object();
    $this->url = $url_object->url . "?pa=" . $this->id;
  }

  /** Check if this "phananh" object is "daxuly" or not */
  private function da_xu_ly($html)
  {
    $els_chitiet_trangthai = $html->find(".ChiTiet_XuLy_Vien .ChiTiet_TrangThai");
    return count($els_chitiet_trangthai) == 0;
    // return $this->daxuly;
  }
}