<?php

$fileArr = file('input4.txt', FILE_IGNORE_NEW_LINES);

$numbers = explode(',', $fileArr[0]);

$pos = 2;

$boards = [];
$board = [];

while ($pos <= count($fileArr)) {
    if ($pos == count($fileArr)) {
        array_push($boards, $board);

        break;
    }

    if (empty($fileArr[$pos])) {
        array_push($boards, $board);
        $board = [];
    } else {
        $noSpaces = preg_replace('/\s+/', '_', $fileArr[$pos]);
        if ($noSpaces[0] == '_') {
            $noSpaces = substr($noSpaces, 1);
        }

        $row = explode('_', $noSpaces);
        array_push($board, $row);
    }

    $pos++;
}

$bingo = false;

$nrPos = 0;
$winningNumber = $numbers[$nrPos];
$winningSum = 0;

while (! $bingo && $nrPos < count($numbers)) {
    $bingoNumber = $numbers[$nrPos];

    foreach ($boards as &$board) {
        $board = markNumberInBoard($board, $bingoNumber);
        if (boardIsComplete($board)) {
            $bingo = true;
            $winningNumber = $bingoNumber;
            $winningSum = calculateWinningSum($board);
        }
    }

    $nrPos++;
}

echo "Winning number is: " . $winningNumber . PHP_EOL;
echo "Sum of unmarked numbers on board is: " . $winningSum . PHP_EOL;
echo "Total score is: " . $winningNumber * $winningSum . PHP_EOL;

function markNumberInBoard(array &$board, int $number): array
{
    foreach ($board as &$row) {
        $row = array_map(function ($val) use ($number) {
            return $val == $number ? 'x' : $val;
        }, $row);
    }

    return $board;
}

function boardIsComplete(array $board): bool
{
    foreach ($board as $row) {
        if (array_unique($row) === ['x']) {
            return true;
        }
    }

    $pos = 0;

    while ($pos < 5) {
        $column = array_column($board, $pos);
        if (array_unique($column) === ['x']) {
            return true;
        }

        $pos++;
    }

    return false;
}

function calculateWinningSum(array $board): int
{
    $sum = 0;
    foreach ($board as $row) {
        $row = array_map(fn ($val) => $val != 'x' ? $val : 0, $row);
        $sum += array_sum($row);
    }

    return $sum;
}
