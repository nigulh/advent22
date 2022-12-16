<?php
# for i in 15; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; echo php $i.php data/$i.a; done


$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', preg_split("/\D+/", preg_replace("/^\D+/", "", $line))); }

echo (new Solution($dataArray))->solve() . "\n";

class Solution
{
  public $data;
  public $map;

  public function __construct($data)
  {
    $this->data = $data;
    for($x = 0; $x < 200; $x++)
    {
      $this->map[$x] = str_pad("", 1000, ".");
    }
  }

  function solve()
  {
    $ret = 0;
    foreach($this->data as $line)
    {
      $this->solveLine($line);
    }
    $this->dfs(500, 0);
    return $this->count;
  }

  public $count = 0;
  function dfs($x, $y)
  {
    if ($y >= 2 + $this->maxY)
    {
      return;
      echo $this->count;
      exit;
      throw new Exception($this->count);
    }
    if ($this->map[$y][$x] !== ".") return;
    foreach([0, -1, 1] as $dx)
    {
      $this->dfs($x + $dx, $y + 1);
    }
    $this->map[$y][$x] = "o";
    $this->count++;
  }

  public $maxY = 0;
  function solveLine($line)
  {
    $isFirst = true;
    foreach (explode(" -> ", $line) as $c)
    {
      [$sx, $sy] = readInts($c);
      $this->maxY = max($this->maxY, $sy);
      if ($isFirst)
      {
        [$ex, $ey] = [$sx, $sy];
        $isFirst = false;
      }
      while($sx != $ex || $sy !== $ey)
      {
        $this->map[$ey][$ex] = "#";
        var_dump([$ex, $ey]);
        if ($ex < $sx) $ex++;
        if ($ex > $sx) $ex--;
        if ($ey < $sy) $ey++;
        if ($ey > $sy) $ey--;
      }
      $this->map[$ey][$ex] = "#";
    }
  }
}


