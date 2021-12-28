<?php
$data = parse('./input');

$calc = new RiskCalculator($data);
$calc->dijkstra(0, 0);
echo $calc->getEndDist();

class RiskCalculator {
  private $data;
  private $todo;
  private $done;
  private $dists;
  private $height;
  private $width;
  private $found;
  private $counter;

  public function __construct($data)
  {
    $height = count($data);
    $width = count($data[0]);
    $mult = 5;
    for ($i = 0; $i < $mult; $i++) {
      for ($j = 0; $j < $mult; $j++) {
        for ($y = 0; $y < $height; $y++) {
          for ($x = 0; $x < $width; $x++) {
            $val = ($data[$y][$x] + $i + $j) % 9;
            if ($val == 0) {$val = 9;}
            $this->data[$height * $j + $y][$width * $i + $x] = $val;
          }
        }
      }
    }

    // $this->showTable($this->data);
    $this->height = count($this->data);
    $this->width = count($this->data[0]);
    $this->dists = [[0]];
    $this->todo = [];
    $this->counter = 0;
    $this->done = array_fill(0, $this->height, array_fill(0, $this->width, false));
    echo $this->height . " x " . $this->width . "\n";
  }

  public function getEndDist(){
    // $this->showTable($this->dists);
    return $this->dists[$this->height - 1][$this->width - 1 ];
  }

  public function dijkstra($x, $y){
    // $this->counter += 1;
    // if ($this->counter / 1000 == ceil($this->counter / 1000)){echo $this->counter."\n";};
    $this->done[$y][$x] = true;
    $dist = $this->dists[$y][$x];
    if (!is_null($this->found)){ 
      return false;
    }
    if ($x == $this->width - 1 && $y == $this->height - 1){ 
      $this->found = $this->dists[$y][$x];
      return false;
    }

    $this->updateDist($dist, $x-1, $y);
    $this->updateDist($dist, $x, $y - 1);
    $this->updateDist($dist, $x+1, $y);
    $this->updateDist($dist, $x, $y + 1);

    asort($this->todo);
    // print_r($this->todo);
    $next = array_splice($this->todo, 0, 1);
    $point = explode(':',key($next) );
    $this->dijkstra($point[0], $point[1]);
  }

  private function updateDist($fromdist, $x, $y){
    if ($x >= 0 && $y >= 0 && $x < $this->width && $y < $this->height && !$this->done[$y][$x]){
      // echo "($dist) $x $y : ";
      $previous = 99999;
      if (!array_key_exists($y, $this->dists)){
        $this->dists[$y] = []; 
      }
      if (array_key_exists($x, $this->dists[$y])){ $previous = $this->dists[$y][$x]; }
      $dist = min($previous, $fromdist + $this->data[$y][$x]);
      $this->dists[$y][$x] = $dist;
      $this->todo["$x:$y"] = $dist; 
      // echo $dist."\n"; 
    }
    return false;
  }

  private function showTable($table){
    $height = count($table);
    $width = count($table[0]);
    for ($y = 0; $y < $height; $y++) {
      for ($x = 0; $x < $width; $x++) {
        echo str_pad($table[$y][$x], 4);
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
