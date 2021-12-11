<?php
$octopuses = parse('./input');
$sum = 0;
for ($i = 0; $i < 100; $i++) {
  $sum += tick($octopuses);
}

echo $sum;

function tick(&$octopuses):int{
  // Add 1
  $octopuses = array_map(fn($line) => array_map(fn($octopus) => $octopus + 1, $line), $octopuses);

  // flash
  $flashed = []; 
  do {
    $newFlashes = []; 
    for ($j = 0; $j < 10; $j++) {
      for ($i = 0; $i < 10; $i++) {
        if (!in_array([$i,$j], $flashed) && $octopuses[$j][$i] > 9){
          // echo "\n         $i $j";
          $newFlashes[] = [$i,$j];
        }
      }
    }
    foreach ($newFlashes as $coords) {
      flashAround($octopuses, $coords); 
    }
    // echo "\n new flashes : ". count($newFlashes);
    $flashed = array_merge($flashed, $newFlashes);
    // echo "\n total = ".join(', ', array_map(fn($coords) => join(':', $coords), $flashed));
  } while (!empty($newFlashes));

  //set flashed to 0
  foreach ($flashed as $coords) {
    $octopuses[$coords[1]][$coords[0]] = 0; 
  }

  return count($flashed);
}

function flashAround(&$octopuses, $coords){
  $i = $coords[0];
  $j = $coords[1];

  // i - 1
  if ($i > 0 ){
    $octopuses[$j][$i - 1] += 1;
    if ($j > 0 ){
      $octopuses[$j - 1][$i - 1] += 1;
    }
    if ($j < 9 ){
      $octopuses[$j + 1][$i - 1] += 1;
    }
  }

  // i
  if ($j > 0 ){
    $octopuses[$j - 1][$i] += 1;
  }
  if ($j < 9 ){
    $octopuses[$j + 1][$i] += 1;
  }

  // i + 1
  if ($i < 9 ){
    $octopuses[$j][$i + 1] += 1;
    if ($j > 0 ){
      $octopuses[$j - 1][$i + 1] += 1;
    }
    if ($j < 9 ){
      $octopuses[$j + 1][$i + 1] += 1;
    }
  }

}


function parse(string $filePath){
  $lines = array_map(fn($line) => str_split(trim($line)), file($filePath));
  return $lines;
}

?>
