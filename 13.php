<?php
# for i in 13; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; echo php $i.php data/$i.a; done


$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', preg_split("/\D+/", preg_replace("/^\D+/", "", $line))); }

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
    $items = [[[2]], [[6]]];
    foreach ($this->data as $i => $line)
    {
      $lines = explode("\n", $line);
      $a1 = $this->toArray($lines[0]);
      $items[] = $a1;
      $a2 = $this->toArray($lines[1]);
      $items[] = $a2;
    }
    usort($items, [$this, 'isOk']);
    foreach($items as $i => $item)
    {
      if($this->isOk($item, [[2]]) == 0) $two = $i + 1;
      if($this->isOk($item, [[6]]) == 0) $six = $i + 1;
    }
    var_dump($two, $six);
    return $two * $six;
  }

  function isOk($a1, $a2)
  {
    if (!is_array($a1) && !is_array($a2)) return $a1 <=> $a2;
    $a1 = is_array($a1) ? $a1 : [$a1];
    $a2 = is_array($a2) ? $a2 : [$a2];
    for ($i = 0; $i < min(count($a1), count($a2)); $i++)
    {
      $ret = $this->isOk($a1[$i], $a2[$i]);
      if ($ret != 0) return $ret;
    }
    if (count($a1) != count($a2))
    {
      return count($a1) <=> count($a2);
    }
    return 0;
  }

  function toArray($input)
  {
    $x = iterator_to_array($this->toTokens(new ArrayIterator(explode(",", $input))));
    $parts = new ArrayIterator(explode(",", $input));
    $generator = $this->toTokens($parts);

    return $this->generate($generator);
  }

  function generate($tokens)
  {
    $tokens->next();
    $ret = [];
    while ($tokens->current() != "]")
    {
      if ($tokens->current() == '[')
      {
        $ret[] = $this->generate($tokens);
        continue;
      }
      $ret[] = $tokens->current();
      $tokens->next();
    }
    $tokens->next();
    return $ret;
  }

  function toTokens(ArrayIterator $parts)
  {
    foreach($parts as $part)
    {
      $i = 0;
      while ($part[$i] == '[')
      {
        yield $part[$i];
        $i++;
      }
      if ($part[$i] != ']')
      {
        yield readInts($part)[0];
      }
      $i = 1;
      while (substr($part, -$i, 1) == ']')
      {
        yield ']';
        $i++;
      }
    }
  }

  function solveLine($line)
  {
    return (int)$line;
  }
}


