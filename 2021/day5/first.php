<?php
$data = parse("./input");
// $data = parse("./example");

$map = new VentureMap($data['width'], $data['height']);

foreach($data['lines'] as $line){
  $map->drawLine($line);
}

echo $map->countOverlaps();

class VentureMap {
  /**
   * @param $map
   */
  public function __construct($width, $height)
  {
    $this->map = array_fill(0, $width, array_fill(0, $height, 0));
  }
  
  public function drawLine($line)
  {
    $xMin = min($line['from']['x'], $line['to']['x']);
    $xMax = max($line['from']['x'], $line['to']['x']);
    $yMin = min($line['from']['y'], $line['to']['y']);
    $yMax = max($line['from']['y'], $line['to']['y']);
    if ($xMin == $xMax ){//horizontal
      for ($y = $yMin; $y <= $yMax; $y++) {
        $this->map[$xMin][$y] += 1;
      }
    } else if ($yMin == $yMax ){ // vertical
      for ($x = $xMin; $x <= $xMax; $x++) {
        $this->map[$x][$yMin] += 1;
      }
    } else {//diagonal
      // for ($x = $xMin; $x <= $xMax; $x++) {
      //   for ($y = $yMin; $y <= $yMax; $y++) {
      //     $this->map[$x][$y] += 1;
      //   }
      // }
    }
  }

  public function countOverlaps():int{
    $count = 0;
    foreach ($this->map as $line){
      foreach ($line as $cell){
        if ($cell > 1) {
          $count += 1;
        }
      }
    }
    return $count;
  }

}

function parse(string $filePath){
  $maxX = 0;
  $maxY = 0;
  $lines = [];

  $inputlines = array_map('trim', file($filePath));
  foreach($inputlines as $inputline){
    $points = explode(' -> ', $inputline);
    $points = array_map(function($point){ return explode(',', $point); }, $points);
    $line = [
      'from' => [
        'x' => $points[0][0],
        'y' => $points[0][1],
      ],
      'to' => [
        'x' => $points[1][0],
        'y' => $points[1][1],
      ],
    ];
    $maxX = max($maxX, $line['from']['x'], $line['to']['x']);
    $maxY = max($maxY, $line['from']['y'], $line['to']['y']);
    $lines[] = $line;
  }

  return [
    'width' => $maxX + 1, 
    'height' => $maxY + 1, 
    'lines' => $lines,
  ];
}

?>
