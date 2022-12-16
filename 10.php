<?php
# for i in 10; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; echo php $i.php data/$i.a; done


$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo (new Solution($dataArray))->solve() . "\n";

class Solution
{
  public $data;

  public function __construct($data)
  {
    $this->data = $data;
  }

  function solve()
  {
    $ret = 0;
    foreach($this->data as $line)
    {
      $ret += $this->solveLine($line);
    }
    return $ret;
  }

  function solveLine($line)
  {
    return (int)$line;
  }
}


