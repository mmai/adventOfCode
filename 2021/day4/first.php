<?php
$data = parse("./input");

foreach($data['numbers'] as $number){
  foreach($data['boards'] as $i => $board){
    $score = $board->play($number);
    if ($score > 0){
      echo $score;die();
    }
    $data['boards'][$i] = $board;
  }
}

/**
 * Board
 */
class Board
{
  private $data;
  private $marks = [
    [false, false, false, false, false],
    [false, false, false, false, false],
    [false, false, false, false, false],
    [false, false, false, false, false],
    [false, false, false, false, false],
  ];
  
  public function __construct($data)
  {
   $this->data = $data; 
   // $this->marks = array_fill(0, 5, array_fill(0, 5, false));
  }

  public function play($number):int{
    for ($i = 0; $i < 5; $i++) {
      for ($j = 0; $j < 5; $j++) {
        // echo "check {$this->data[$i][$j]}";
        if ($this->data[$i][$j] == $number){
          $this->marks[$i][$j] = true;
          if ($this->rowComplete($i) || $this->columnComplete($j)){
            return $number * $this->unmarkedCellsSum();
          }
        }
      }
    }

    return 0;
  }

  private function unmarkedCellsSum(){
    $sum = 0;
    for ($i = 0; $i < 5; $i++) {
      for ($j = 0; $j < 5; $j++) {
        if (!$this->marks[$i][$j]){
          $sum += $this->data[$i][$j];
        }
      }
    }
    return $sum;
  }

  private function rowComplete($i){
    return !in_array(false, $this->marks[$i]);
  }

  private function columnComplete($j){
    $transposed = $this->transpose($this->marks);
    return !in_array(false, $transposed[$j]);
  }

  private function transpose($array) {
    return array_map(null, ...$array);
  }


}

function parse(string $filePath){
  $lines = array_map('trim', file($filePath));
  $numbers = explode(',', array_shift($lines));
  $boards = [];
  $board = [];
  foreach($lines as $line){
    if (!empty($line)){
      $board[] = preg_split('/\s+/', $line);
    } else if (!empty($board)){
      $boards[] = $board;
      $board = [];
    }
  }
  if (!empty($board)){
    $boards[] = $board;
  }

  return [
    'numbers' => $numbers, 
    'boards' => array_map(function($board){ return new Board($board); }, $boards),
  ];
}

?>
