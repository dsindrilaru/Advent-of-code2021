<?php

$fileArr = file('input3.txt', FILE_IGNORE_NEW_LINES);

$o2 = bindec(getRating($fileArr));
$co2 = bindec(getRating($fileArr, 'co2'));

echo "Life support rating is: " . $o2 * $co2 . PHP_EOL;

function getRating(array $dataArray, string $type = 'o2')
{
    $newArr = array_map(fn ($line) => str_split($line), $dataArray);

    $pos = 0;
    while ($pos < 12 && count($newArr) > 1) {
        $bitOne = 0;
        foreach ($newArr as $nr) {
            $bitOne += $nr[$pos];
        }

        $bitZero = count($newArr) - $bitOne;

        $bit = 1;
        if ($type === 'o2' && $bitOne < $bitZero) {
            $bit = 0;
        } elseif ($type !== 'o2' && $bitOne >= $bitZero) {
            $bit = 0;
        }


        foreach ($newArr as $k => $val) {
            if ($val[$pos] != $bit) {
                unset($newArr[$k]);
            }
        }

        $pos++;
    }

    $bin = array_pop($newArr);
    return implode($bin);
}
