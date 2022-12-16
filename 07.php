<?php

$data = file_get_contents($argv[1] ?? "php://stdin");
function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo solve(explode("\n", $data)) . "\n";
//echo array_sum(array_map('solveLine', explode("\n", $data))) . "\n";

function solve($lines)
{
  $files = [];
  $pwd = [];
  foreach($lines as $line)
  {
    $cmd = explode(' ', $line);
    if ($line[0] === '$')
    {
      if ($cmd[1] === 'cd')
      {
        if ($cmd[2] === "..")
        {
          array_pop($pwd);
        }
        else
        {
          $pwd[] = $cmd[2];
        }
      }
    }
    else
    {
      /*$path = "";
      foreach ($pwd as $d)
      {
        $path .= $d . "/";
      }
      if ($files[$path] > 0)
      {
        echo "continue" . $path . "\n";
        continue;
      }*/
      $path = "";
      foreach ($pwd as $d)
      {
        $path .= $d . "/";
        $files[$path] = ($files[$path] ?? 0) + (int)$cmd[0];
      }
    }
  }
  $ret = 0;
  var_dump($files);
  foreach($files as $k => $x)
  {
    if ($x <= 100000) $ret += $x;
  }
  $tot = $files["//"];
  $needed = $tot - 40000000;
  $min = $files["//"];
  foreach($files as $x)
  {
    if ($x >= $needed) $min = min($min, $x);
  }
  echo $min;
  //echo $ret;
}

