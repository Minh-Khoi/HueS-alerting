<?php

require_once dirname(__FILE__, 3) . "/" . "libs/simple_html_dom.php";

class last_index_writer
{
  private $file_path = "/data.json", $url = "https://tuongtac.thuathienhue.gov.vn/";
  private $indexes_array;
  /** This variable will be save to file "data.json" */
  private $last_reflecting_index;

  /**
   * Class constructor.
   */
  public function __construct()
  {
    $this->get_indexes_of_reflecting();
    // $this->get_last_reflecting_index();
    $this->generate_json_file();
  }

  /** 
   * scrape the website "tuongtac.thuathienhue.gov.vn" and
   * set the variable '$indexes_array'
   */
  private function get_indexes_of_reflecting()
  {
    $html_from_url = file_get_html($this->url);
    $all_phananhtieude_anchor_array =  $html_from_url->find(".PhanAnh_TieuDe a");
    // die(isset($all_phananhtieude_anchor_array));
    $indexes_phananh_array = [];
    foreach ($all_phananhtieude_anchor_array as $index => $phananh_anchor) {
      $href = $phananh_anchor->href;
      $index_of_phananh = str_replace("?pa=", "", $href);
      // echo $index_of_phananh . "<br>";
      array_push($indexes_phananh_array, (int) $index_of_phananh);
    }
    rsort($indexes_phananh_array);
    $this->indexes_array = ($indexes_phananh_array);
  }

  /** 
   * get content of the file "/data.json" for the integer which was used as 
   * the first index for the crawling interators
   */
  public function get_index_start_crawling()
  {
    $index_start_crawling = file_get_contents(dirname(__FILE__) . $this->file_path);
    $this->last_reflecting_index = (int) $index_start_crawling;
    // echo $this->last_reflecting_index . "<br>";
    return $this->last_reflecting_index + 1;
  }

  /** 
   * save to file "data.json" the first index for the crawling interator.
   * It may be the last reflecting index which is scraped from homepage "tuongtac.thuathienhue.gov.vn"
   * or the oldest index of phananh_chuaxuly. THis index is updated every time the crawler finish its job.
   */
  public function generate_json_file(int $index = null, bool $first_time = true)
  {
    $file = dirname(__FILE__) . $this->file_path;
    $fop = fopen($file, 'w');
    if (is_null($index) && $first_time) {
      $this->last_reflecting_index = $this->indexes_array[0];
      fwrite($fop, json_encode($this->last_reflecting_index));
    } else if (!is_null($index)) {
      fwrite($fop, $index);
    }
    fclose($fop);
  }
}

// $writer = new last_index_writer();
// echo ($writer->get_last_reflecting_index());
// die();
