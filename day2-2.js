/**
 * Advent of Code 2021 - Day 2 Part 2
 */

const fs = require('fs')

let dataByLines = [];
let position = 0;
let depth = 0;
let aim = 0;

try {
    dataByLines = fs.readFileSync('day2_input.txt','utf-8').split(/\r?\n/);
} catch(err) {
    console.error(err);
}

// Loop through the commands and modify the position and depth as required
dataByLines.forEach((line) => {
    let array = line.split(' '), command = array[0], amount = 1 * array[1];
    switch(command) {
        case 'forward':
            position += amount;
            depth += aim * amount;
            break;
        case 'down':
            aim += amount;
            break;
        case 'up':
            aim -= amount;
            break;
    }
});

console.log('part 2 result = ', position * depth);
