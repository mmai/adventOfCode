<?php
$lines = parse('./input');

echo array_sum(array_map('checkLine', $lines));

// $count = array_reduce($input, function($sum, $line){
//   return $sum + checkLine($line);
// }, 0);
//
// echo $count;

function checkLine(array $line): int{
  $signs = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
  ];

  $scores = [
    ')' => 3,
    ']' => 57,
    '}' => 1197,
    '>' => 25137,
  ];

  $opened = [];
  foreach ($line as $char){
    if (array_key_exists($char, $signs)){
      $opened[] = $char;
    } else {
      if (empty($opened)){
        return $scores[$char];
      }
      $expected = $signs[array_pop($opened)];
      if ($char != $expected){
        return $scores[$char];
      }
    }
  }
  return 0;
}


function parse(string $filePath){
  $lines = array_map(fn($line) => str_split(trim($line)), file($filePath));
  return $lines;
}

?>
