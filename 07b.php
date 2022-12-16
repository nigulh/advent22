<?php

$data = file_get_contents($argv[1] ?? "php://stdin");
function readInts($line) { return array_map('intval', explode(" ", $line)); }

echo solve(new ArrayIterator(explode("\n", $data))) . "\n";
echo array_sum(array_map('solveLine', explode("\n", $data))) . "\n";

function solve(Iterator $it)
{
  while( $it->valid() )
  {
    echo $it->key() . "=" . $it->current() . "\n";
    $it->next();
  }
}

function solveLine($line)
{

}

