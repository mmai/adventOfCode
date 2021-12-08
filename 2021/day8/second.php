<?php
$input = parse('./input');

$count = array_reduce($input, function($sum, $line){
  $decoder = makeDecoder($line['patterns']);
  $decoded = array_map(fn($pattern) => decode($decoder, $pattern), $line['digits']);
  $digits = signalsToDigit($decoded);
  return $sum + (int)$digits;
}, 0);

echo $count;

function decode(array $decoder, string $str):string{
  $before = str_split($str);
  $after = array_map(fn($s) => $decoder[$s], $before);
  sort($after);
  return join($after);
}

function makeDecoder(array $patterns):array {
  $patterns = array_map('str_split', $patterns);
  $c_f = $patterns[0]; // 1
  $a_c_f = $patterns[1]; // 7
  $b_c_d_f = $patterns[2]; // 4
  $all = $patterns[9]; // 8
  $a_d_g = array_intersect($patterns[3], $patterns[4], $patterns[5]); // 5 segments : 2, 3, 5
  $a_b_f_g = array_intersect($patterns[6], $patterns[7], $patterns[8]); // 6 segments : 0, 6, 9

  $a = array_diff($a_c_f, $c_f); // ok
  $b = array_diff($a_b_f_g, $a_d_g, $c_f);
  $c = array_diff($a_c_f, $a_b_f_g); // ok
  $d = array_diff($a_d_g, $a_b_f_g);
  $f = array_diff($c_f, $c);
  $g = array_diff($a_b_f_g, $a, $b_c_d_f);
  $e = array_diff($all, $a, $b, $c, $d, $f, $g);

  return [
    reset($a) => 'a',
    reset($b) => 'b',
    reset($c) => 'c',
    reset($d) => 'd',
    reset($e) => 'e',
    reset($f) => 'f',
    reset($g) => 'g',
  ];

}

function signalsToDigit(array $signals):int{
  $dict = [
    "cf" => "1",
    "acf" => "7",
    "bcdf" => "4",
    "acdeg" => "2",
    "acdfg" => "3",
    "abdfg" => "5",
    "abdefg" => "6",
    "abcdfg" => "9",
    "abcefg" => "0",
    "abcdefg" => "8",
  ];

  return join(array_map(fn($signal) => $dict[$signal], $signals));
}

function parse(string $filePath){
  $lines = array_map('trim' , file($filePath));
  $lines = array_map(function($line){
    $parts = explode('|', $line);
    $patterns =  explode(' ', trim($parts[0]));
    usort($patterns, fn($a, $b) => strlen($a)-strlen($b));
    return [
      'patterns' => $patterns,
      'digits' => explode(' ', trim($parts[1]))
    ];
  }, $lines);
  return $lines;
}

?>
