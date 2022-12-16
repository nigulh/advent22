<?php

$filename = $argv[1] ?? "php://stdin";
$data = file_get_contents($filename);
function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo solve(explode("\n", $data)) . "\n";
echo solveLine(explode("\n", $data)) . "\n";

function solve($lines)
{
  foreach($lines as $line)
  {
    $pairs = explode(",", $line);
    $left = explode("-", $pairs[0]);
    $right = explode("-", $pairs[1]);
    if (contains($left, $right[0]) || contains($left, $right[1]))
    {
      $ret += 1;
    }
    else
      if (contains($right, $left[0]) || contains($right, $left[1]))
      {
        $ret += 1;
      }
  }
  return $ret;
}

function contains($range, $num)
{
  return $range[0] <= $num && $num <= $range[1];
}

function solve2($lines)
{

}

