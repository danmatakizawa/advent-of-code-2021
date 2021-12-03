/**
 * Advent of Code 2021 - Day 2 Part 1
 */

const fs = require('fs')

let dataByLines = [];
let position = 0;
let depth = 0;

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
            break;
        case 'down':
            depth += amount;
            break;
        case 'up':
            depth -= amount;
            break;
    }
});

console.log('part 1 result = ', position * depth);
