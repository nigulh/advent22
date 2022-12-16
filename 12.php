<?php
# for i in 12; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; echo php $i.php data/$i.a; done


$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', preg_split("/\D+/", preg_replace("/^\D+/", "", $line))); }

echo (new Solution($dataArray))->solve() . "\n";

class Solution
{
  public $data;
  private $X;
  private $Y;

  public function __construct($data)
  {
    $this->data = $data;
  }

  public $map;
  public $visited = [];
  function solve()
  {
    $this->map = [];
    $ret = 0;
    $this->Y = strlen($this->data[0]);
    $this->X = count($this->data);
    foreach ($this->data as $x => $line)
    {
      for ($y = 0; $y < $this->Y; $y++)
      {
        $this->map[$x][] = -2;
        if ($this->data[$x][$y] == 'E')
        {
          $this->visited[] = [$x, $y, 0];
          $this->data[$x][$y] = 'z';
        }
        if ($this->data[$x][$y] == 'S')
        {
          $ex = $x;
          $ey = $y;
          $this->data[$x][$y] = 'a';
        }
      }
    }
    $ret = 1000000;
    for ($i = 0; $i < count($this->visited); $i++)
    {
      [$cx, $cy, $v] = $this->visited[$i];
      if (0 <= $cx && $cx < $this->X && 0 <= $cy && $cy < $this->Y)
      {
        if ($this->map[$cx][$cy] === -2)
        {
          $this->map[$cx][$cy] = $v;
          if ($this->data[$cx][$cy] == 'a')
          {
            $ret = min($ret, $v);
          }
          $dx = [1, 0, -1, 0];
          $dy = [0, 1, 0, -1];
          for ($d = 0; $d < 4; $d++)
          {
            if (ord($this->data[$cx][$cy]) - 1 <= ord($this->data[$cx + $dx[$d]][$cy + $dy[$d]]))
            {
              $this->visited[] = [$cx + $dx[$d], $cy + $dy[$d], $v + 1];
            }
          }
        }
      }
    }
    return $ret;
    return $this->map[$ex][$ey];
  }

  function solveLine($line)
  {
    return (int)$line;
  }
}


