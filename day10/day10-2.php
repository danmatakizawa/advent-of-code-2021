<?php /** @noinspection ALL */

/**
 * Advent of Code – Day 10 Part 1
 */

require('../common.php');

// Process each line and collect the individual scores in an array.
$scores = [];
$lines = loadFileIntoLines('./input.txt');
$minion = new Minion();
foreach($lines as $key => $line) {
    $output = $minion->processLine($line, $closers, $scoreTable);
    if ($output > 0) $scores[] = $output;
}

// we then return the middle score (there is always an odd number of scores apparently)
sort($scores);
$answer = $scores[floor(sizeof($scores) / 2)];

print PHP_EOL . 'PART 2 ANSWER = ' . $answer . PHP_EOL;

class Minion {

    public $scoreTable = ['(' => 1, '[' => 2, '{' => 3, '<' => 4];
    public $closerTable = [')' => '(', ']' => '[', '}' => '{', '>' => '<'];

    public function processLine(string $string): int
    {
        // start with an empty context.
        $context_stack = [];

        // okay, let's walk through string. If it errors out, we return 0.
        foreach (str_split($string) as $char) {
            if (array_key_exists($char, $this->closerTable)) {
                if ($context_stack[0] === $this->closerTable[$char]) {
                    array_shift($context_stack); // matching close tag. remove from context stack
                } else {
                    return 0; // error! Worth nothing.
                }
            } else {
                array_unshift($context_stack, $char); // add to context stack
            }
        }

        // if you made it here, it's time to score based on the remaining stack.
        $score = 0;
        foreach ($context_stack as $val) {
            $score = 5 * $score + $this->scoreTable[$val];
        }
        return $score;

    }

}