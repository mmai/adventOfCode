<?php
$lines = parse('./input');
$scores = array_map('checkLine', $lines);
$scores = array_filter($scores);
sort($scores);

$middleIdx = (count($scores) - 1 ) / 2;
echo $scores[$middleIdx];

function checkLine(array $line): int{
  $signs = [
    '(' => ')',
    '[' => ']',
    '{' => '}',
    '<' => '>',
  ];

  $scores = [
    '(' => 1,
    '[' => 2,
    '{' => 3,
    '<' => 4,
  ];

  $opened = [];
  foreach ($line as $char){
    if (array_key_exists($char, $signs)){
      $opened[] = $char;
    } else {
      if (empty($opened)){
        return 0;
      }
      $expected = $signs[array_pop($opened)];
      if ($char != $expected){
        return 0;
      }
    }
  }

  $score = array_reduce(array_reverse($opened), function ($sum, $char) use ($scores){
    return $sum * 5 + $scores[$char];
  },  0);
  return $score;
}


function parse(string $filePath){
  $lines = array_map(fn($line) => str_split(trim($line)), file($filePath));
  return $lines;
}

?>
