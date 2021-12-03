/**
 * Advent of Code Day 1 Part 2
 */

const fs = require('fs')

let dataByLines = [];

try {
    dataByLines = fs.readFileSync('day1_input.txt','utf-8').split(/\r?\n/);
} catch(err) {
    console.error(err);
}

let prev = null, increases = 0, val;

// switched to for loop so I can manage indices easier.
// start on 3rd entry in array so we can start summing value with 2 previous entries.
for (let i = 2; i < dataByLines.length; i++) {
    val = parseInt(dataByLines[i - 2]) + parseInt(dataByLines[i - 1]) + parseInt(dataByLines[i]);
    if (prev !== null && val > prev) increases++;
    prev = val;
}

console.log('increases = ', increases);