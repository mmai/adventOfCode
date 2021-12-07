<?php
$positions = explode(',', file_get_contents('input'));
$positions = array_map(function($s){return (int)$s;}, $positions);

sort($positions);
$from = $positions[0];
$to = $positions[count($positions) - 1];


function getFuel($a, $b){
  $n = abs($a - $b);
  return $n * ($n + 1) * 0.5;
}

$costs = array_map(function($target) use ($positions){
  return array_reduce($positions, function ($sum, $pos) use ($target){ 
    return $sum + getFuel($target, $pos); 
  }, 0);
}, range($from, $to));

echo min($costs);

?>
