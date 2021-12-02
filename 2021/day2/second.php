<?php
$lines = file("./input");
// $lines = file("./example");

$horizontal = 0;
$depth = 0;
$aim = 0;

foreach($lines as $line){
  $action = parseLine(trim($line));
  switch($action['direction']){
  case "forward":
    $horizontal += $action['amount'];
    $depth += $aim * $action['amount'];
    break;
  case "up":
    $aim -= $action['amount'];
    break;
  case "down":
    $aim += $action['amount'];
    break;
  }
}
echo $horizontal * $depth;

function parseLine(string $line){
  $parts = explode(' ', $line);
  $res = [
    'direction' => $parts[0],
    'amount' => $parts[1],
  ];
  return $res;
}
?>
