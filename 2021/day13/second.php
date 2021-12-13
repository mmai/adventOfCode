<?php
$doc = parse('./input');

$instr = $doc['instr'];
$dots = $doc['dots'];
foreach ($instr as $ins){
  $dots = foldDoc($dots, $ins);
}
display($dots);

function display($dots){
  $ymax = 0;
  $xmax = 0;
  foreach($dots as $dot){
    $ymax = max($ymax, $dot['y']);
    $xmax = max($xmax, $dot['x']);
  }

  for ($y = 0; $y <= $ymax; $y++) {
    for ($x = 0; $x <= $xmax; $x++) {
      $char = in_array(['x' => $x, 'y' => $y], $dots) ? "#" : " ";
      echo $char;
    }
    echo "\n";
  }

}

function foldDoc($dots, $instr){
  $paper = [];
  $foldedDots = [];

  $toFold = [];
  foreach($dots as $dot){
    $diff = $dot[$instr['along']] - $instr['pos'];
    if ($diff < 0){
      if (!array_key_exists('x'.$dot['x'], $paper)){
        $paper['x'.$dot['x']] = [$dot['y']];
      } else {
        $paper['x'.$dot['x']][] = $dot['y'];
      }
      $foldedDots[] = $dot;
    } else {
      $candidate = ['x' => $dot['x'], 'y' => $dot['y']];
      $candidate[$instr['along']] -= 2 * $diff;
      $toFold[] = $candidate;
    }
  }
  // print_r($paper);

  foreach($toFold as $dot){
    if (array_key_exists('x'.$dot['x'], $paper)){
      if (!in_array($dot['y'], $paper['x'.$dot['x']])){
        $foldedDots[] = $dot;
      }
    } else {
      $foldedDots[] = $dot;
    }
  }

  return $foldedDots;
}

function parse(string $filePath){
  $lines = array_map('trim', file($filePath));
  $dots = [];
  $line = array_shift($lines);
  while (!empty($line)) {
    $dot = explode(',', $line); 
    $dots[] = ['x' => $dot[0], 'y' => $dot[1]];
    $line = array_shift($lines);
  } ;

  $instructions = [];
  foreach ($lines as $line){
    $ins = explode('=', substr($line, 11));
    $instructions[] = ['along' => $ins[0], 'pos' => $ins[1]];
  }

  return [
    'dots' => $dots,
    'instr' => $instructions,
  ];
}

?>
