<?php
$lines = array_map('trim', file("./input"));

// Part 1
function getGamma($lines){
  $size = 0;
  $bitsCount = [];
  foreach($lines as $line){
    $size += 1;
    $chars = str_split($line);
    foreach($chars as $i => $char){
      if (count($bitsCount) <= $i){ $bitsCount[$i] = 0; }
      if ($char == "1"){ $bitsCount[$i] += 1;} 
    }
  }
  $gamma = array_map(function($count) use ($size){ return $count * 2 >= $size ? 1 : 0; }, $bitsCount);
  return $gamma;
}


// Part 2
$oxygenCriteria = function($gamma, $line, $pos):bool{
  return substr($line, $pos, 1) == $gamma[$pos];
};

$co2Criteria = function($gamma, $line, $pos):bool{
  return substr($line, $pos, 1) != $gamma[$pos];
};

$oxygen = searchCriteria($oxygenCriteria, $lines);
$oxygen = bindec($oxygen);
$co2 = bindec(searchCriteria($co2Criteria, $lines));

echo "$oxygen * $co2 =".$oxygen * $co2;

function searchCriteria($criteria, $lines): string {
  $lineSize = strlen($lines[0]);
  $pos = 0;
  while (count($lines) > 1 && $pos < $lineSize ){
    $gamma = getGamma($lines);
    $lines = array_filter($lines, function($line) use ($gamma, $criteria, $pos){ 
      return $criteria($gamma, $line, $pos);
    });
    $pos += 1;
  }
  if (count($lines) != 1){ throw new Error("Found ".count($lines)." lines") ;}
  return reset($lines);
}

?>
