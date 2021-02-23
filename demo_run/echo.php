<?php
error_reporting(E_ERROR | E_PARSE);


$count = 0;
setInterval(function () use ($count) {
  $GLOBALS['count']++;
  echo "hello, minhkhoi 5 GIÂY LẦN THỨ {$GLOBALS['count']} \n";
}, 5000);

function setInterval($f, $milliseconds)
{
  $seconds = (int) $milliseconds / 1000;
  do {
    $f();
    sleep($seconds);
  } while (true);
}