<?php

$filename = $argv[1] ?? "php://stdin";
$data = file_get_contents($filename);
function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo solve($data) . "\n";
echo solveLine($data) . "\n";

function solve($data)
{
  $ret = 0;
  foreach(explode("\n", $data) as $line)
  {
    $calc = calc($line[0], $line[2]);
    $ret += $calc;
  }
  return $ret;
}

function calc($oppL, $meL)
{
  $opp = array_flip(str_split( "ABC"))[$oppL];
  $me = array_flip(str_split( "XYZ"))[$meL];
  if ($opp == $me) return $me + 4;
  if (($opp + 1) % 3 == $me) return $me + 7;
  return $me + 1;
}

function solve2($data)
{
  $ret = 0;
  foreach(explode("\n", $data) as $line)
  {
    $calc = calc2($line[0], $line[2]);
    $ret += $calc;
  }
  return $ret;
}

function calc2($oppL, $meL)
{
  $opp = array_flip(str_split( "ABC"))[$oppL];
  $meWin = array_flip(str_split( "YZX"))[$meL];
  $me = ($opp + $meWin) % 3;
  if ($opp == $me) $ret = $me + 4;
  else if (($opp + 1) % 3 == $me) $ret = $me + 7;
  else $ret = $me + 1;
  return $ret;
}



