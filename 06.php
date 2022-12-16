<?php

$data = file_get_contents($argv[1] ?? "php://stdin");
function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo solve(explode("\n", $data)) . "\n";
echo array_sum(array_map('solveLine', explode("\n", $data))) . "\n";

function solve($lines)
{

}

function solveLine($line)
{
  $ret = 0;
  for ($i = 0; $i < strlen($line) - 14; $i++)
  {
    $found = [];
    for ($j = 0; $j < 14; $j++)
    {
      $found[$line[$i+$j]] = 1;
    }
    if (count($found) == 14) return $i + 14;
  }
}

