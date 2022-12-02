<?php
$lines = file("./input");
// $lines = file("./example");

function trad($in):string {
  $dict = [
"A" => 1,
"B" => 2,
"C" => 3,
"X" => 0,
"Y" => 3,
"Z" => 6,
];
return $dict[$in];
}

function rsp(int $a, int $res):int{
  if ($res == 3){
    return $a;
  }

  $s = 0;
  if ($res == 0){
    $s = $a - 1;
  } else {
    $s = $a + 1;
  }

  if ($s > 3) return 1;
  if ($s < 1) return 3;
  return $s;
}

function res($a, $b){
  $score = trad($b);
  $score += rsp(trad($a), trad($b));
  return $score;
}

$matches = array_map(function($line){
    $vals = explode(' ', trim($line));
    return res($vals[0], $vals[1]);
  }, $lines );

# first
echo array_sum($matches);

?>
