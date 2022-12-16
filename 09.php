<?php
# for i in 08; do cp _.php $i.php; touch data/$i.in; touch data/$i.sample; echo done

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
    $ret = [];
    $dd = array_flip(["R", "U", "L", "D"]);
    $dx = [1, 0, -1, 0];
    $dy = [0, 1, 0, -1];
    $xs = []; $ys = [];
    for($i = 0; $i < 10; $i++) {$xs[] = 0; $ys[] = 0;}
    $map = array_fill(-20, 40, str_pad("", 40, "."));
    foreach($this->data as $line)
    {
      [$dirString, $num] = explode(' ', $line);
      for($i = 0; $i < $num; $i++)
      {
        $d = $dd[$dirString];
        $xs[0] += $dx[$d];
        $ys[0] += $dy[$d];
        //var_dump($xs);
        //var_dump($ys);
        for($j=1; $j<10; $j++)
        {
          [$xs[$j], $ys[$j]] = $this->getPos($xs[$j - 1], $ys[$j - 1], $xs[$j], $ys[$j]);
          $ret[$j]["$xs[$j]:$ys[$j]"] = 1;
        }
        $map[$ys[9]][$xs[9] + 20] = "#";
        //var_dump("$xs[9]:$ys[9]");
      }
    }
    //var_dump($ret[2]);
    for ($i = 1; $i < 10; $i++)
    {
      //var_dump([$i, count($ret[$i])]);
    }
    //var_dump($map);
    return count($ret[9]);
  }

  function solveLine($line)
  {
    return (int)$line;
  }/**
 * @param int $hx
 * @param int $hy
 * @param mixed $tx
 * @param int $ty
 * @return array
 */
  private function getPos(int $hx, int $hy, mixed $tx, int $ty): array
  {
    $x = ($hx <=> $tx);
    if (abs($tx-$hx) + abs($ty-$hy) == 3)
    {
      if (abs($tx - $hx) > 1) $ty = $hy;
      if (abs($ty - $hy) > 1) $tx = $hx;
    }
    var_dump([$hx, $tx, $hx <=> $tx]);
    //$tx += $hx <=> $tx;
    $tx = min($tx, $hx + 1);
    $tx = max($tx, $hx - 1);
    $ty = min($ty, $hy + 1);
    $ty = max($ty, $hy - 1);
    return array($tx, $ty);
  }
}


