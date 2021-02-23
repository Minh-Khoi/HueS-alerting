<?php
require_once dirname(__FILE__, 3) . "/" . "libs/simple_html_dom.php";
require_once dirname(__FILE__, 2) . '/last_index_writer/last_index_writer.php';

class scanner
{
  private $keyword;
  private $indexes_phananh_related_to_keywork = [],
    $all_phananh_related_to_keywork = [],
    $url = "https://tuongtac.thuathienhue.gov.vn/";

  /**
   * Class scanner constructor.
   */
  public function __construct(string $key)
  {
    set_time_limit(60);
    $this->keyword = $key;
    $this->scan();
  }

  /** 
   * This function will scan the the home page of "tuongtac.thuathienhue.gov.vn"
   * then it scrape the page of "phananh" (specified by index). If the keyword have been found in the 
   * page details. The detail of that "phananh" will be add to "$this->all_phananh_related_to_keywork"
   */
  private function scan()
  {
    $writer = new last_index_writer();
    $last_index = $writer->get_last_reflecting_index();
    $index_scanned = $last_index + 1;
    $phananh_html_page = null;
    do {
      $phananh_html_page = $this->crawl_by_index($index_scanned);
      $phananh_detail_elements = $phananh_html_page->find(".ChiTiet_Vien > .ChiTiet_NoiDung");

      $phananh_detail_text = (count($phananh_detail_elements) > 0) ? $phananh_detail_elements[0]->innertext : "";
      if (
        strpos(strtoupper($phananh_detail_text), strtoupper($this->keyword)) != false
        || (strpos(strtoupper($phananh_detail_text), strtoupper($this->keyword)) === 0)
      ) {
        array_push($this->all_phananh_related_to_keywork, $phananh_detail_elements[0]->innertext);
        array_push($this->indexes_phananh_related_to_keywork, $index_scanned);
      }
      $index_scanned++;
      var_dump($index_scanned == intval($last_index) + 100);
      // } while (count($phananh_html_page->find(".ViPham_DeMuc")) == 0);
    } while ($index_scanned < intval($last_index) + 100);
  }

  /** 
   * THis function crawl the page which shows the particular-indexed "phananh"
   * then return all the page as a "simple_html_dom" object
   */
  private function crawl_by_index(int $index)
  {
    $html = file_get_html($this->url . "?pa=" . $index);
    // echo $index . "<br>";
    // echo "<pre>" . $html->innertext . "</pre>";
    return $html;
  }

  /** THe public function to get value fetched from data.json */
  public function get_all_phananh_related_to_keywork()
  {
    //
  }
}
// echo "FUCK <br>";
$scanner = new scanner("Cầu Bán Nguyệt");
echo "<pre>" . print_r($scanner, true) . "</pre>";