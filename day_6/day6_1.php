<?php

$fileArr = file('input6.txt', FILE_IGNORE_NEW_LINES);

$fishArr = explode(',', $fileArr[0]);
$fishLifespan = array_fill(0, 9, 0);

foreach ($fishArr as $initialFish) {
    $fishLifespan[$initialFish]++;

}
$day = 1;

while ($day <= 256) {
    $parents = array_shift($fishLifespan);

    array_push($fishLifespan, $parents);

    $fishLifespan[6] += $parents;

    $day++;
}

echo array_sum($fishLifespan).PHP_EOL;


