<?php
$data = parse('./input');

$rules = $data['rules'];
$formula = $data['formula'];

$db = [ ];
$level = 40;

$counts = getCounts($rules, $formula, $level);
echo max($counts) - min($counts);


function getCounts($rules, $formula, $level){
  global $db;
  $dbkey = 'l'.$level;
  if (!array_key_exists($dbkey, $db)){$db[$dbkey] = [];}
  if (array_key_exists($formula, $db[$dbkey])){ return $db[$dbkey][$formula];}

  $counts = [];
  $len = strlen($formula);
  for ($i = 0; $i < $len; $i++) {
    $part = substr($formula, $i, 2);
    $found = $rules[$part] ?? "";
    if ($level == 0){
      addLetterCount($counts, $part[0]);//only first
    } else if (!empty($found)){
      $counts = mergeCounts($counts, getCounts($rules, $part[0].$found, $level - 1));
      $counts = mergeCounts($counts, getCounts($rules, $found.$part[1], $level - 1));
      substractLetterCount($counts, $found);
      if ($i < $len - 2){
        substractLetterCount($counts, $part[1]);
      }
    }
  }
  $db[$dbkey][$formula] = $counts;
  return $counts;
}

function mergeCounts($counts, $new){
  foreach($new as $char => $count){
    if (!array_key_exists($char, $counts)){ $counts[$char] = 0; }
    $counts[$char] += $new[$char];
  }
  return $counts;
}

function substractLetterCount(&$counts, $char){
  if (!array_key_exists($char, $counts)){ $counts[$char] = 0; }
  $counts[$char] -= 1;
}

function addLetterCount(&$counts, $char){
  if (!array_key_exists($char, $counts)){ $counts[$char] = 0; }
  $counts[$char] += 1;
}

function parse(string $filePath){
  $lines = array_map('trim', file($filePath));
  $formula = array_shift($lines);
  array_shift($lines);

  $rules = [];
  foreach ($lines as $line) {
    $els = explode(' -> ', $line);
    $rules[$els[0]] = $els[1];
  }

  return [
    'formula' => $formula,
    'rules' => $rules,
  ];
}

?>
