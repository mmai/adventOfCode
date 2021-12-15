<?php
$data = parse('./example');

$rules = $data['rules'];
$formula = $data['formula'];
echo "--- $formula --\n\n";

stream_filter_register("decode_filter", "decode_filter") or die("Erreur lors de l'enregistrement du filtre");

function step($rules, $formula){
  $twentyGiga = 20 * 1024 * 1024 * 1024;
  $input = fopen("php://temp/maxmemory:$twentyGiga",'w+');
  stream_filter_append($input, "decode_filter", STREAM_FILTER_WRITE, ['rules' => $rules]);
  echo "spliting\n";
  $formula = str_split($formula);
  echo "writing\n";
  foreach($formula as $char){
    fwrite($input, $char);
  }
  echo "rewinding\n";
  rewind($input);
  echo "get contents\n";
  $res =  stream_get_contents($input);
  echo "close \n\n";
  fclose($input);
  return $res;
}

for ($i = 0; $i < 40; $i++) {
  echo $i."\n";
  $formula = step($rules, $formula);
}


echo "couting";
$chars = str_split($formula);
$counts = [];
foreach ($chars as $char) {
  if (!array_key_exists($char, $counts)){ $counts[$char] = 0; }
  $counts[$char] += 1; 
}

print_r($counts);

echo max($counts) - min($counts);
die();

class decode_filter extends php_user_filter
{
    private $bufferHandle = '';
    private $first = null;

    function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
          $char = $bucket->data;
          $consumed += $bucket->datalen;
          if (!is_null($this->first)){
            $search = $this->first . $char;
            if (array_key_exists($search, $this->params['rules'])){
              $newChar = $this->params['rules'][$this->first.$char];
              $buck = stream_bucket_new($this->bufferHandle, '');
              $buck->data = $newChar;
              stream_bucket_append($out, $buck);
            }
          }
          $this->first = $char;
          stream_bucket_append($out, $bucket);
        }
        return PSFS_PASS_ON;
    }

    public function onCreate()
    {
        $this->bufferHandle = @fopen('php://temp', 'w+');
        if (false !== $this->bufferHandle) {
            return true;
        }
        return false;
    }
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
