<?php
$input = parse('./input');

$count = array_reduce($input, function($sum, $line){
  $uniques = array_filter($line['digits'], fn($digit) => in_array(strlen($digit), [2, 3, 4, 7]) );
  return $sum + count($uniques);
}, 0);

echo $count;

function parse(string $filePath){
  $lines = array_map('trim' , file($filePath));
  $lines = array_map(function($line){
    $parts = explode('|', $line);
    return [
      'patterns' => explode(' ', $parts[0]),
      'digits' => explode(' ', $parts[1])
    ];
  }, $lines);
  return $lines;
}

?>
