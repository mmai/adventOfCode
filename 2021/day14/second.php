<?php
$data = parse('./input');

$rules = $data['rules'];
$formula = str_split($data['formula']);

for ($i = 0; $i < 40; $i++) {
  echo $i . "\n";
  $formula = doStep($formula, $rules);
}

$count = array_reduce($formula, function($counts, $char) {
  if (!array_key_exists($char, $counts)){ $counts[$char] = 0; }
  $counts[$char] += 1;
  return $counts;
}, [] );

$maxVal = max($count);
$minVal = min($count);
echo $maxVal - $minVal;

function doStep($formula, $rules){
  $newFormula = [];
  $formula = array_reverse($formula);
  $count = count($formula);
  while ($count > 1){
    $char = array_pop($formula);
    $search = $char. end($formula);
    $newFormula[] = $char;
    $newFormula[] = $rules[$search] ?? "";
    $count -= 1;
  }
  $newFormula[] = end($formula);
  return $newFormula;
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
