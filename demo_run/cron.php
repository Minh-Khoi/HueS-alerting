<?php
require_once dirname(__FILE__, 2) . "/crawler/action/action.php";
require_once dirname(__FILE__, 2) . "/crawler/model/dao/phananh_chuaxuly_dao.php";
require_once dirname(__FILE__, 2) . "/crawler/model/dto/phananh_chuaxuly.php";


setInterval(function () {
  // save_new_keywords();
  cron_function();
}, 1000 * 60 * 60 * 24);

/** Init the setInterval function, similar to the method setInterval in Javascript */
function setInterval($f, $milliseconds)
{
  $seconds = (int) $milliseconds / 1000;
  do {
    $f();
    sleep($seconds);
  } while (true);
}

/** Do the th cron job. THis function is invoked in setInterval, so that it will run day by day */
function cron_function()
{
  $action = new action();
  $dao = new phananh_chuaxuly_dao();
  $array_of_keywords = $action->get_all_keywords();
  $phananh = null;
  $last_index = $action->find_max_index();
  // echo $last_index; die();
  $now_time = strtotime("now");
  $time_of_15_day_ago = strtotime("-15 days");

  do {
    $phananh = new phananh_chuaxuly($last_index);
    if (!$phananh->daxuly) {
      $having_right_keywords = $action->having_right_keyword($phananh->noi_dung, $array_of_keywords);
      $phananh_is_new = $dao->checkif_phananh_is_new($phananh->id);
      if ($having_right_keywords && $phananh_is_new) {
        $dao->create($phananh);
      }
      echo "phản ánh số " . $phananh->id . ($having_right_keywords ? " đã " : " không ") . "được lưu vào CSDL\n";
      die();
    }
    $last_index--;
  } while (strtotime($phananh->ngay_update) < $time_of_15_day_ago);
}


// function save_new_keywords()
// {
//   $action = new action();
//   $keywords_array = $GLOBALS['argv'];
// }