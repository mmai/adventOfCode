<?php
$lines = array_map('trim', file("./input"));

$size = 0;
$bitsCount = [];
foreach($lines as $line){
  $size += 1;
  $chars = str_split($line);
  foreach($chars as $i => $char){
    if (count($bitsCount) <= $i){ $bitsCount[$i] = 0; }
    if ($char == "1"){ $bitsCount[$i] += 1;} 
  }
}

$gamma = array_map(function($count) use ($size){ return $count * 2 > $size ? 1 : 0; }, $bitsCount);
$epsilon = array_map(function($binval) { return $binval == 1 ? 0 : 1; }, $gamma);

$gamma = bindec(join("", $gamma));
$epsilon = bindec(join("", $epsilon));

echo $gamma * $epsilon;

?>
