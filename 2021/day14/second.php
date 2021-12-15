<?php
$data = parse('./example');

$rules = $data['rules'];
$formula = $data['formula'];

$input = fopen('php://memory','r+');
fwrite($input, $formula);

for ($i = 0; $i < 40; $i++) {
  echo $i."\n";
  $input = decode($rules, $input);
}
rewind($input);

$counts = [];
while (!feof($input)) {
  $char = fread($input, 1);
  if (!empty($char)){
    if (!array_key_exists($char, $counts)){ $counts[$char] = 0; }
    $counts[$char] += 1; 
  }
}
// print_r($counts);
fclose($input);

echo max($counts) - min($counts);

function decode($rules, $input){
  rewind($input);
  $output = fopen("php://temp", 'w+');

  $first = fread($input, 1);
  while (!feof($input)) {
    $second = fread($input, 1);
    $decoded = $rules[$first.$second] ?? "";
    fwrite($output, $first.$decoded);
    $first = $second;
  }
  fwrite($output, $first);
  fclose($input);
  return $output;
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
