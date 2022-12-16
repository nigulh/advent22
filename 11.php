<?php
# for i in 10; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; done

$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n\n", $dataString);
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

  public $items = [];
  function solve()
  {
    $ret = 0;
    $inspects = [];
    foreach($this->data as $m => $lines)
    {
      $explode = explode("\n", $lines);
      $starting = $explode[1];

      foreach(explode(' ', $starting) as $items)
      {
        if ((int)$items > 0)
        {
          $mods = [];
          for($mod = 2; $mod < 25; $mod++)
          {
            $mods[$mod] = (int)$items % $mod;
          }
          $this->items[$m][] = $mods;
        }
      }
    }
    for($round = 0; $round < 10000; $round++)
    {
      foreach(array_keys($this->items) as $m)
      {
        $items = $this->items[$m];
        foreach ($items as $item)
        {
          $inspects[$m] = ($inspects[$m] ?? 0) + 1;
          $op = explode("\n", $this->data[$m])[2];
          $opParts = explode(" ", $op);
          $mods = [];
          for($mod = 2; $mod < 25; $mod++)
          {
            $xs = [];
            foreach([5, 7] as $i)
            {
              $xs[] = $opParts[$i] == "old" ? $item[$mod] : (int)$opParts[$i];
            }
            if ($opParts[6] == '+') $x = $xs[0] + $xs[1]; else $x = $xs[0] * $xs[1];
            $mods[$mod] = $x % $mod;
          }
          $x = $mods;
          //$x = (int)floor($x/3);

          $div = explode(' ', explode("\n", $this->data[$m])[3])[5];
          $toM = explode(' ', explode("\n", $this->data[$m])[$x[$div] == 0 ? 4 : 5])[9];
          $this->items[$toM][] = $x;
        }
        $this->items[$m] = [];
      }
    }
      //var_dump($this->items);
    var_dump($inspects);
    rsort($inspects);
    return $inspects[0] * $inspects[1];
    return $ret;
  }



  function solveLine($line)
  {
    return (int)$line;
  }
}


