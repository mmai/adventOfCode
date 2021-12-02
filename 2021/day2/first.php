<?php
$lines = file("./input");
// $lines = file("./example");

$horizontal = 0;
$depth = 0;

foreach($lines as $line){
  $action = parseLine(trim($line));
  switch($action['direction']){
  case "forward":
    $horizontal += $action['amount'];
    break;
  case "up":
    $depth -= $action['amount'];
    break;
  case "down":
    $depth += $action['amount'];
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
