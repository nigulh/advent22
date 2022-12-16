<?php
# for i in 08; do cp _.php $i.php; touch data/$i.in; touch data/$i.sample; done

$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo solve($dataArray) . "\n";

function solve($lines)
{
  $ret = 0;
  $dx = [0, 1, 0, -1];
  $dy = [1, 0, -1, 0];
  $nx = count($lines);
  $ny = strlen($lines[0]);
  $rets = 0;
  foreach($lines as $x => $line)
  {
    for($y = 0; $y < strlen($line); $y ++)
    {
      $ok = false;
      $s = 1;
      for($d = 0; $d < 4; $d++)
      {
        $dok = true;
        $bx = $x;
        $by = $y;
        $sc = 0;
        do
        {
          $bx += $dx[$d];
          $by += $dy[$d];
          if (0 <= $bx && $bx < $nx && 0 <= $by && $by < $ny)
          {
            $sc++;
            if ($lines[$x][$y] <= $lines[$bx][$by])
            {
              //var_dump([$x, $y, $lines[$x][$y], $bx, $by, $lines[$bx][$by], $sc]);
              //exit;
              break;
              $dok = false;
            }
          } else break;
        } while ($dok);
        $s *= $sc;
        //$ok = $ok || $dok;
      }
      //var_dump([$x, $y, $ok]);
      if ($ok) {
        $ret++;
      }
      $rets = max($rets, $s);
    }
  }
  return $rets;
}

function solveLine($line)
{
  return (int)$line;
}

