<?php
$timers = explode(',', file_get_contents('input'));

$memory = [];

$days = 256;
$total = 0;
foreach ($timers as $timer) {
  $total += countChilds($timer, $days);
}
echo $total;

function countChilds($timer, $days){
  global $memory;
  $key = "$days : $timer";
  if (array_key_exists($key, $memory)){ return $memory[$key]; }
  $days = $days - $timer;
  if ($days <= 0){
    return 1;
  }
  $count = countChilds(6, $days - 1) + countChilds(8, $days - 1);
  $memory[$key] = $count;
  return $count;
}
?>
