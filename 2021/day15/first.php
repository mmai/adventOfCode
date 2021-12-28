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
    $this->data = $data;
    $this->height = count($this->data);
    $this->width = count($this->data[0]);
    $this->dists = [[0]];
    $this->todo = [];
    $this->counter = 0;
    // echo $this->height . " x " . $this->width . "\n";
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

    // print_r($this->todo);
    $next = array_splice($this->todo, 0, 1);
    $point = explode(':',key($next) );
    $this->dijkstra($point[0], $point[1]);
  }

  private function addTodo($x, $y, $dist){
    $this->todo["$x:$y"] = $dist; 
    asort($this->todo);
  }

  private function updateDist($fromdist, $x, $y){
    if ($x >= 0 && $y >= 0 && $x < $this->width && $y < $this->height && !in_array("$x:$y", $this->done)){
      // echo "($dist) $x $y : ";
      $previous = 99999;
      if (!array_key_exists($y, $this->dists)){
        $this->dists[$y] = []; 
      }
      if (array_key_exists($x, $this->dists[$y])){ $previous = $this->dists[$y][$x]; }
      $dist = min($previous, $fromdist + $this->data[$y][$x]);
      $this->dists[$y][$x] = $dist;
      $this->addTodo($x, $y, $dist);
      // echo $dist."\n"; 
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
