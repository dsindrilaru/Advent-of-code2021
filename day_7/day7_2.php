<?php

$fileArr = file('input7.txt', FILE_IGNORE_NEW_LINES);

$crabPositions = explode(',', $fileArr[0]);

$mean = floor(array_sum($crabPositions) / count($crabPositions));

$fuel = 0;

foreach($crabPositions as $crab) {
    $distance = abs($crab - $mean);
    $fuel += $distance * $distance++ / 2;
}

echo $fuel.PHP_EOL;