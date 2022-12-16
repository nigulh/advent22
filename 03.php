<?php

$filename = $argv[1] ?? "php://stdin";
$data = file_get_contents($filename);

echo solve($data) . "\n";
echo solveLine($data) . "\n";

function solve($data)
{
  $ret = 0;
  foreach(explode("\n", $data) as $line)
  {
    $len = strlen($line) / 2;
    $left = substr($line, 0, $len);
    $right = substr($line, $len);
    $arr = [$left, $right];
    $ret += getCommonLetter($arr);
  }
  return $ret;
}

function getCommonLetter($arr)
{
  for($i = 0; $i < 26; $i++)
  {
    foreach([1 + $i => chr(ord('a') + $i), 27 + $i => chr(ord('A') + $i)] as $x => $ch)
    {
      $ok = true;
      foreach($arr as $part)
      {
        $ok = $ok && str_contains($part, $ch);
      }
      if ($ok) {
        return $x;
      }
    }
  }
}

function solve2($data)
{
  $ret = 0;
  $cur = [];
  foreach(explode("\n", $data) as $line)
  {
    $cur[] = $line;
    if (count($cur) == 3)
    {
      $ret += getCommonLetter($cur);
      $cur = [];
    }
  }
  return $ret;
}

