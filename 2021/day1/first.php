<?php
//$lines = file("./input");
$lines = file("./example");

$count = 0;
$current = null;
foreach($lines as $depth){
  $depth = trim($depth);
  if (!is_null($current) && $current < $depth){
    $count += 1;
  }
  $current = $depth;
}
echo "---> ".$count;
?>
