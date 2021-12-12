<?php
$map = parse('./input');
$paths = getPaths($map, [], 'start', null, 0);
echo count($paths);

function getPaths($map, $visited, string $begin, $smallVisited):array{
  $visited[] = $begin;
  if ($begin == 'end') {return [['end']];}
  $paths = [];
  foreach($map[$begin] as $cavern){
    $smallVisitedCur = $smallVisited;
    $smallAllowed = true;
    if ($cavern == strtolower($cavern) && in_array($cavern,$visited)){
      $smallAllowed = false;
      if ($cavern != "start" && is_null($smallVisitedCur)){
        $smallVisitedCur = $cavern;
        $smallAllowed = true;
      }
    }
    if ( $cavern == strtoupper($cavern) || $smallAllowed){
      $childs = getPaths($map, $visited, $cavern, $smallVisitedCur);
      foreach ($childs as $child){
        $paths[] = array_merge([$begin], $child);
      }
    }
  }
  return $paths;
}

function parse(string $filePath){
  $map = [];
  $paths = array_map(fn($line) => array_filter(explode('-', trim($line)), fn($part) => $part != '-'), file($filePath));
  foreach ($paths as $path) {
    if (!array_key_exists($path[0], $map)){ $map[$path[0]] = []; }
    if (!in_array($path[1], $map[$path[0]])){ $map[$path[0]][] = $path[1]; }
    if (!array_key_exists($path[1], $map)){ $map[$path[1]] = []; }
    if (!in_array($path[0], $map[$path[1]])){ $map[$path[1]][] = $path[0]; }
  }
  return $map;
}

?>
