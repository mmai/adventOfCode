<?php
$floor = parse('./input');
$width = count($floor[0]);
$height = count($floor);
// echo "width : $width , height: $height\n";


$sum = 0;
for ($y = 0; $y < $height; $y++) {
  for ($x = 0; $x < $width; $x++) {
    if (isMin($x,$y)){
      // echo $floor[$y][$x]."\n";
      $sum += $floor[$y][$x] + 1;
    }
  }
}

echo $sum;

function isMin($x, $y):bool{
  global $floor;
  global $width;
  global $height;

  $cells = [];
  if ($y > 0) { $cells[] = $floor[$y - 1][$x]; }
  if ($y < $height - 1) { $cells[] = $floor[$y + 1][$x]; }
  if ($x > 0) { $cells[] = $floor[$y][$x - 1]; }
  if ($x < $width - 1) { $cells[] = $floor[$y][$x + 1]; }
  return $floor[$y][$x] < min($cells);
}

function parse($path){
  $lines = array_map('trim', file($path));
  $floor = array_map('str_split', $lines);
  return $floor;
}
?>
