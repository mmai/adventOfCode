<?php
$lines = file("./input");
// $lines = file("./example");

$count = 0;
$current = null;
$window = [];
foreach($lines as $depth){
  $depth = trim($depth);
  $window[] = $depth;
  if (count($window) > 2){
    if (count($window) > 3){
      array_shift($window);
    }
    $window_sum = array_sum($window);
    echo $window_sum."\n";
    if (!is_null($current) && $current < $window_sum){
      $count += 1;
    }
    $current = $window_sum;
  }
}
echo "---> ".$count;
?>
