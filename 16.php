<?php
# for i in 16; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; echo php $i.php data/$i.a; done

ini_set('memory_limit', '-1');

$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', preg_split("/[^\d\-]+/", preg_replace("/^[^\d\-]+/", "", $line))); }

echo (new Solution($dataArray))->solve() . "\n";

class Solution
{
  public $data;
  public $tunnels;
  public $rates;
  public $bits;
  public $nameToBit;
  public $nameToKey;

  public function __construct($data)
  {
    $this->data = $data;
  }

  function solve()
  {
    $ret = 0;
    foreach($this->data as $line)
    {
      $this->solveLine($line);
    }
    $this->nameToBit = array_flip($this->bits);
    $this->nameToKey = array_flip(array_keys($this->tunnels));
    $total = (1 << count($this->nameToBit)) - 1;
    $ret = 0;
    for($me = 0; $me < $total; $me++)
    {
      if ($me % 100 == 0) var_dump($me);
      $dp1 = $this->dp($me, "AA", 26, "AA");
      $dp2 = $this->dp($total - $me, "AA", 26, "AA");
      $ret = max($ret, $dp1 + $dp2);
    }
    var_dump(memory_get_usage());
    var_dump([count($this->map), count($this->map2)]);
    return $ret;
  }

  function getKey($opened, $where, $timeLeft, $elephant)
  {
    return (($opened * 31 + $timeLeft) * 50 + $this->nameToKey[$where]) * 50 + $this->nameToKey[$elephant];
  }

  public $map = [];
  function dp($opened, $where, $timeLeft, $elephant)
  {
    $ret = &$this->map[$this->getKey($opened, $where, $timeLeft, $elephant)];
    if (!isset($ret))
    {
      if ($timeLeft == 0) return 0;
      $ret = 0;
      $bit = $this->nameToBit[$where] ?? null;
      if ($bit !== null)
      {
        if (($opened & (1 << $bit)) == 0)
        {
          $ret = $this->dp2($opened + (1 << $bit), $where, $timeLeft, $elephant) + ($timeLeft - 1) * $this->rates[$where];
          //var_dump([$ret, $opened, $where, $timeLeft]);
        }
      }
      foreach($this->tunnels[$where] as $w2)
      {
        $ret = max($ret, $this->dp2($opened, $w2, $timeLeft, $elephant));
      }
    }
    return $ret;
  }
  public $map2 = [];
  function dp2($opened, $where, $timeLeft, $elephant)
  {
    return $this->dp($opened, $where, $timeLeft - 1, $elephant);
    $ret = &$this->map2[$this->getKey($opened, $where, $timeLeft, $elephant)];
    if (!isset($ret))
    {
      if ($timeLeft == 0) return 0;
      $ret = 0;
      $bit = $this->nameToBit[$elephant] ?? null;
      if ($bit !== null)
      {
        if (($opened & (1 << $bit)) == 0)
        {
          $ret = $this->dp($opened + (1 << $bit), $where, $timeLeft - 1, $elephant) + ($timeLeft - 1) * $this->rates[$elephant];
          //var_dump([$ret, $opened, $where, $timeLeft]);
        }
      }
      foreach($this->tunnels[$elephant] as $w2)
      {
        $ret = max($ret, $this->dp($opened, $where, $timeLeft - 1, $w2));
      }
    }
    return $ret;
  }
  function solveLine($line)
  {
    $words = preg_split("/,? /", $line);
    $me = $words[1];
    $tunnels = [];
    for($i = 9; $i < count($words); $i++)
    {
      $tunnels[] = $words[$i];
    }
    $this->tunnels[$me] = $tunnels;
    $rate = readInts($line)[0];
    $this->rates[$me] = $rate;
    if ($rate > 0) $this->bits[] = $me;
  }
}


