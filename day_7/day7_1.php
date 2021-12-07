<?php

$fileArr = file('input7.txt', FILE_IGNORE_NEW_LINES);

$crabPositions = explode(',', $fileArr[0]);

sort($crabPositions);

$medianIndex = count($crabPositions) / 2;
$idealPosition = $crabPositions[$medianIndex];

$fuel = 0;

foreach($crabPositions as $crab) {
    $fuel += abs($crab - $idealPosition);
}

echo $fuel.PHP_EOL;

