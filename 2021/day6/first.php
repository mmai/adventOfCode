<?php
$data = parse("./input");
// $data = parse("./example");

$fishes = $data['fishes'];

$days = 80;
for ($i = 0; $i < $days; $i++) {
  // echo " \n---- day $i --- \n";
  $newFishes = [];
  foreach($fishes as $id => $fish){
    if ($fish->passDay()){
      // echo "new fish!\n";
      $newFishes[] = new Fish();
    }
    $fishes[$id] = $fish;
  }
  $fishes = array_merge($fishes, $newFishes);
}
echo count($fishes);

class Fish
{
  private $timer;
  
  public function __construct($timer = 8)
  {
    $this->timer = $timer;
  }

  public function passDay():bool{
    // echo $this->timer . "\n";
    $this->timer -= 1;
    if ($this->timer < 0){
      $this->timer = 6;
      return true;
    }
    return false;
  }

}

function parse(string $filePath){
  $fishes = [];

  $lines = array_map('trim', file($filePath));
  $numbers = explode(',', array_shift($lines));

  foreach($numbers as $number){
    $fishes[] = new Fish($number);
  }

  return [
    'fishes' => $fishes,
  ];
}

?>
