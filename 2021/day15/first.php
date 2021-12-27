<?php
$data = parse('./input');

$calc = new RiskCalculator($data);
$calc->dijkstra(0, 0);
echo $calc->getEndDist();

class RiskCalculator {
  private $data;
  private $done;
  private $dists;
  private $height;
  private $width;
  private $counter;

  public function __construct($data)
  {
    $this->data = $data;
    $this->height = count($this->data);
    $this->width = count($this->data[0]);
    $this->dists = [[0]];
    $this->counter = 0;
    echo $this->height . " x " . $this->width . "\n";
  }

  public function getEndDist(){
    // $this->showDists();
    return $this->dists[$this->height - 1][$this->width - 1 ];
  }

  public function dijkstra($x, $y){
    // $this->counter += 1;
    // if ($this->counter / 100 == ceil($this->counter / 100)){echo $this->counter."\n";};
    // echo "$x:$y \n";
    $this->done[] = "$x:$y";
    $dist = $this->dists[$y][$x];
    $todo = [];
    $todo[($x-1).":$y"] = $this->updateDist($dist, $x-1, $y);
    $todo["$x:".($y-1)] = $this->updateDist($dist, $x, $y - 1);
    $todo[($x+1).":$y"] = $this->updateDist($dist, $x+1, $y);
    $todo["$x:".($y+1)] = $this->updateDist($dist, $x, $y + 1);
    $todo = array_filter($todo);
    asort($todo);
    foreach($todo as $point => $risk){
      $point = explode(':', $point);
      $this->dijkstra($point[0], $point[1]);
    }
  }

  private function updateDist($dist, $x, $y){
    if ($x >= 0 && $y >= 0 && $x < $this->width && $y < $this->height && !in_array("$x:$y", $this->done)){
      // echo "($dist) $x $y : ";
      $previous = 99999;
      if (!array_key_exists($y, $this->dists)){
        $this->dists[$y] = []; 
      }
      if (array_key_exists($x, $this->dists[$y])){ $previous = $this->dists[$y][$x]; }
      $this->dists[$y][$x] = min($previous, $dist + $this->data[$y][$x]);
      // echo $this->dists[$y][$x]."\n"; 
      return $this->dists[$y][$x];
    }
    return false;
  }

  private function showDists(){
    for ($y = 0; $y < $this->height; $y++) {
      for ($x = 0; $x < $this->width; $x++) {
        echo str_pad($this->dists[$y][$x], 4);
      }
      echo "\n";
    }
  }

}


function parse(string $filePath){
  $lines = array_map(function ($line){return str_split(trim($line));}, file($filePath));
  return $lines;
}

?>
