<?php
$data = parse('./input');

$rules = $data['rules'];
$formula = str_split($data['formula']);

for ($i = 0; $i < 10; $i++) {
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
  while (!empty($formula)){
    $char = array_shift($formula);
    $search = $char. ($formula[0] ?? '');
    $newFormula[] = $char;
    $newFormula[] = $rules[$search] ?? "";
  }
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
