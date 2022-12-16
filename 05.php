<?php

$data = file_get_contents($argv[1] ?? "php://stdin");
function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo solve(explode("\n\n", $data)) . "\n";
echo array_sum(array_map('solveLine', explode("\n", $data))) . "\n";

function solve($lines)
{
  $data = [];
  foreach(explode("\n", $lines[0]) as $line)
  {
    $numCols = (strlen($line) + 1) / 4;
    for($c = 0; $c < $numCols; $c++)
    {
      $x = $line[4*$c + 1];
      if ($x !== ' ')
      {
        $data[$c+1] = $x . ($data[$c+1] ?? "");
      }
    }
  }
  ksort($data);
  foreach(explode("\n", $lines[1]) as $line)
  {
    [$_, $num, $_, $from, $_, $to] = explode(" ", $line);

    //for($i = 0; $i < $num; $i++)
    {
      $moved = substr($data[$from], -$num);
      $data[$from] = substr($data[$from], 0, strlen($data[$from]) - $num);
      $data[$to] = $data[$to] . $moved;
    }
  }


  $ret = "";
  foreach($data as $x)
  {
    $ret .= substr($x, -1);
  }

  return $ret;
}

function solveLine($line)
{

}

