<?php
# for i in 14; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; echo php $i.php data/$i.a; done


$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', preg_split("/[^\d\-]+/", preg_replace("/^[^\d\-]+/", "", $line))); }

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
    $signals = [];
    foreach($this->data as $line)
    {
      $signals[] = readInts($line);
    }
    $ret = 0;
    $yMax = 2000000;
    //$yMax = 10;
    $seen = [];
    for($yMe = 0; $yMe < 2 * $yMax; $yMe++)
    {
      $segments = [];
      foreach ($signals as $signal)
      {
        $filled = $this->getFilled($yMe, ...$signal);
        if ($filled[0] < $filled[1])
        {
          $segments[] = $filled;
        }
        if ($signal[3] == $yMe)
        {
          $seen[$signal[2]] = 1;
        }
      }
      sort($segments);
      $lastX = -$yMe;
      foreach ($segments as [$a, $b])
      {
        if ($lastX < $a && $lastX > 0)
        {
          print_r([$lastX, $yMe, $yMe + 4000000 * $lastX]);
        }
        $lastX = max($lastX, $a);
        $ret += max(0, $b - $lastX);
        foreach ($seen as $x)
        {
          if ($lastX <= $x && $x < $b)
          {
            $ret -= 1;
          }
        }
        $lastX = max($lastX, $b);
      }
    }
    return $ret;
  }

  function getFilled($yMe, $xs, $ys, $xb, $yb)
  {
    $d = (int)abs($xb-$xs) + (int)abs($ys-$yb);
    $rem = $d - (int)abs($yMe-$ys);
    //if ($rem < 0) return [0, 0];
    return [$xs-$rem, $xs+$rem+1];
  }

  function solveLine($line)
  {
    return (int)$line;
  }
}


