<?php

/**
 * Advent of Code 2021 - DAY 4
 */

require('./BingoCard.php');

// load the input file. Grab numbers, and feed bingo card generator the lines.
$filename = './input.txt';
$fp = fopen($filename, 'r');
$numbers = explode(',', trim(fgets($fp, filesize($filename))));
$bingoCards = BingoCard::generateFromFile($fp);
fclose($fp);

$winningCardCount = 0;

// Loop through the numbers. Trying to catch the first and the last winners and print out their scores.
for ($i = 0; $i < sizeof($numbers); $i++) {
    foreach($bingoCards as $key => $bingoCard) {

        if ($bingoCard->winType === false && $bingoCard->listen($numbers[$i]) !== false) {

            $winningCardCount++;

            // First card to win!
            if ($winningCardCount == 1) {
                print PHP_EOL;
                print '****************************************' . PHP_EOL;
                print '* PART ONE: ' . PHP_EOL;
                print '****************************************' . PHP_EOL . PHP_EOL;
                print 'Bingo Card ' . $key . ' won on ' . $bingoCard->winType . ' ' . $bingoCard->winId . ' with a score of ' . $bingoCard->getScore() . PHP_EOL;
                $bingoCard->print();
            }

            // Last card to win!
            if ($winningCardCount == sizeof($bingoCards)) {
                print PHP_EOL;
                print '****************************************' . PHP_EOL;
                print '* PART TWO: ' . PHP_EOL;
                print '****************************************' . PHP_EOL . PHP_EOL;
                print 'The Last Bingo Card ' . $key . ' won on ' . $bingoCard->winType . ' ' . $bingoCard->winId . ' with a score of ' . $bingoCard->getScore() . PHP_EOL;
                $bingoCard->print();
                break 2;
            }
        }
    }
}

print PHP_EOL . "Completed!" . PHP_EOL;
exit();