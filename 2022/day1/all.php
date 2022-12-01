<?php
$lines = file("./input");

$elves = [];
$count = 0;
$current = [];
foreach($lines as $calories){
  if (empty(trim($calories)) && !empty($current)){
    $elves[] = $current;
    $current = [];
    continue;
  }
  $current[] = $calories;
}

$sums = array_map(fn($elv) => array_sum($elv), $elves);


# first
echo max($sums);

# second
rsort($sums);
echo $sums[0] + $sums[1] + $sums[2];
?>
