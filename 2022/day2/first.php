<?php
$lines = file("./input");
// $lines = file("./example");

function trad($in):string {
  $dict = [
"A" => 1,
"B" => 2,
"C" => 3,
"X" => 1,
"Y" => 2,
"Z" => 3,
];
return $dict[$in];
}

function rsp(int $a, int $b):int{
  // echo "$a $b";
  switch ($a - $b){
  case 0:
  return 0;
  case 1:
  return -1;
  case 2:
  return 1;
  case -1:
  return 1;
  case -2:
  return -1;
}
}

function res($a, $b){
  $score = trad($b);
  switch (rsp(trad($a), trad($b))){
    case 0:
    $score += 3;
    break;
    case 1:
    $score += 6;
    break;
  }
  // echo " -> $score";
  return $score;
}

$matches = array_map(function($line){
    $vals = explode(' ', trim($line));
    return res($vals[0], $vals[1]);
  }, $lines );

# first
echo array_sum($matches);

?>
