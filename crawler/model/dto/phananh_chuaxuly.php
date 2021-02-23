<?php
require_once dirname(__FILE__, 2) . "/url.php";
require_once dirname(__FILE__, 3) . "/libs/simple_html_dom.php";
require_once dirname(__FILE__, 3) . "/action/last_index_writer/last_index_writer.php";


class phananh_chuaxuly
{
  public $id, $noi_dung, $ngay_update, $donvi_xuly, $thoi_han, $ket_qua, $da_xem;
  private $url;

  /**
   * Class model dto constructor.
   */
  public function __construct(int $id)
  {
    $this->id = $id;
    $this->set_url();
    $this->crawl_by_index();
  }


  private function crawl_by_index()
  {
    $html = file_get_html($this->url);
    // Write the code below to set value for variables $noi_dung, $ngay_update, $donvi_xuly, $thoi_han,
    // $ket_qua, $da_xem ..... Remember to check if the phananh is solved or not??

    // Write te code below to save the oldest index of phananh_chuaxuly...


  }


  private function set_url()
  {
    $url_object = new url_object();
    $this->url = $url_object->url . "?pa=" . $this->id;
  }
}