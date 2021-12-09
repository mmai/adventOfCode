<?php
$floor = parse('./input');
$width = count($floor[0]);
$height = count($floor);

$basinsSizes = [];
for ($y = 0; $y < $height; $y++) {
  for ($x = 0; $x < $width; $x++) {
    if (isMin($x,$y)){
      $basin = enlargeBasin([], $x, $y);
      $basinsSizes[] = count($basin);
    }
  }
}

rsort($basinsSizes);
echo $basinsSizes[0] * $basinsSizes[1] *  $basinsSizes[2];


function enlargeBasin($basin, $x, $y):array{
  global $floor;
  global $width;
  global $height;

  if (!in_array("$x:$y", $basin)){
    $basin[] = "$x:$y";
    $level = $floor[$y][$x];
    if ($level == 8) return $basin;
    if (0 < $y && $floor[$y - 1][$x] == $level + 1){
      $basin = enlargeBasin($basin, $x, $y - 1);
    }
    if ($y < $height - 1 && $floor[$y + 1][$x] == $level + 1){
      $basin = enlargeBasin($basin, $x, $y + 1);
    }

    if (0 < $x && $floor[$y][$x - 1] == $level + 1){
      $basin = enlargeBasin($basin, $x - 1, $y);
    }
    if ($x < $width - 1 && $floor[$y][$x + 1] == $level + 1){
      $basin = enlargeBasin($basin, $x + 1, $y);
    }
  }
  return $basin;
}

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
