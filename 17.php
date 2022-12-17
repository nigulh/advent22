<?php
# for i in 16; do cp _.php $i.php; touch data/$i.b; touch data/$i.a; echo php $i.php data/$i.a; done


$dataString = file_get_contents($argv[1] ?? "php://stdin");
$dataArray = explode("\n", $dataString);
$dataIterator = new ArrayIterator($dataArray);

function readInts($line) { return array_map('intval', preg_split("/[^\d\-]+/", preg_replace("/^[^\d\-]+/", "", $line))); }

echo (new Solution($dataArray))->solve() . "\n";



class Solution
{
  public $data;
  public $map = [];
  public $maxX = 0;
public $pieces = [
[[0,0],[1,0],[2,0],[3,0]],
[[0,1],[1,0],[1,1],[1,2],[2,1]],
[[0,0],[1,0],[2,0],[2,1],[2,2]],
[[0,0],[0,1],[0,2],[0,3]],
[[0,0],[1,0],[0,1],[1,1]],
];

  public function __construct($data)
  {
    $this->data = $data;
  }

  function solve()
  {
    $ret = 0;
    $numPieces = 1000000000000;
    $retMap = [];
    for($piece = 0; $piece < $numPieces; $piece++)
    {
      $curX = $this->maxX + 4;
      $curY = 2;
      while (true)
      {
        if (!$this->isValid($curX - 1, $curY, $piece % 5))
        {
          $this->fixThePiece($curX, $curY, $piece);
          break;
        }
        $curX--;
        if ($this->isValid($curX, $curY + $this->getRight(), $piece % 5))
        {
          $curY += $this->getRight();
        }
        $this->pos++;
      }
      if (isset($retMap[$piece % 5][$this->getIteratorPos()]))
      {
        [$a, $b] = $retMap[$piece % 5][$this->getIteratorPos()];
        $extraPieces = $piece - $a;
        $extraHeight = $this->maxX - $b;
        if (($numPieces-1) % $extraPieces == $piece % $extraPieces)
        {
          var_dump($this->maxX + ($extraHeight * ($numPieces -1- $piece) / $extraPieces));
        }
        //var_dump([$extraPieces, $extraHeight]);
      }
      $retMap[$piece % 5][$this->getIteratorPos()] = [$piece, $this->maxX];
    }

    var_dump($this->maxX);
    return $ret;
  }

  function getPos($dx, $dy, $pieceId)
  {
    foreach($this->pieces[$pieceId] as [$py, $px])
    {
      $x = $px + $dx;
      $y = $py + $dy;
      yield [$x, $y];
    }
  }
  function isValid($dx, $dy, $pieceId)
  {
    foreach($this->getPos($dx, $dy, $pieceId) as [$x, $y])
    {
      if (!(0 <= $y && $y < 7)) return false;
      if ($x >= $this->maxX) continue;
      if ($x < 0) return false;
      if ($this->map[$x][$y] == "#") return false;
    }
    return true;
  }

  public $pos = 0;
  function getRight()
  {
    return $this->data[0][$this->getIteratorPos()] == ">" ? 1 : -1;
  }

  function solveLine($line)
  {
    return (int)$line;
  }

  /**
   * @param mixed $curX
   * @param int $curY
   * @param int $piece
   * @return void
   */
  private function fixThePiece(mixed $curX, int $curY, int $piece): void
  {
    $maxX = $this->maxX;
    foreach ($this->getPos($curX, $curY, $piece % 5) as [$x, $y])
    {
      $maxX = max($maxX, $x + 1);
    }
    for ($x = $this->maxX; $x < $maxX; $x++)
    {
      $this->map[] = ".......";
    }
    $this->maxX = $maxX;
    foreach ($this->getPos($curX, $curY, $piece % 5) as [$x, $y])
    {
      $this->map[$x][$y] = "#";
    }
  }

  /**
   * @return int
   */
  private function getIteratorPos(): int
  {
    $dataCount = strlen($this->data[0]);
    $pos = ($this->pos) % $dataCount;
    return $pos;
  }
}


