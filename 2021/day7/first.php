<?php
$positions = explode(',', file_get_contents('input'));
$positions = array_map(function($s){return (int)$s;}, $positions);

sort($positions);

$middleId = intdiv(count($positions), 2);
$middle = $positions[$middleId];

$fuel = array_reduce($positions, function($sum, $pos) use ($middle){ return $sum + abs($pos - $middle); }, 0);

echo $fuel;

?>
