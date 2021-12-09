/**
 * ADVENT OF CODE 2021 DAY 9 PART 1
 */

const common = require('../common.js');

function main() {
    let filename = 'input.txt';
    let mappy = new Mappy(common.loadFileIntoLines(filename));
    console.log('PART 1 OUTPUT = ', mappy.analyze());
}

class Mappy {

    constructor(lines) {
        this.width = lines[0].length;
        this.height = lines.length;
        this.lines = lines;
        console.log(this);
    }

    at(x,y) {
        return parseInt(this.lines[y].charAt(x));
    }

    analyze() {

        let risk = 0;

        for (let x = 0; x < this.width; x++) {
            for (let y = 0; y < this.height; y++) {

                let pointVal = this.at(x,y);
                if (x > 0)                  if (pointVal >= this.at(x - 1, y)) continue;
                if (x < (this.width - 1))   if (pointVal >= this.at(x + 1, y)) continue;
                if (y > 0)                  if (pointVal >= this.at(x, y - 1)) continue;
                if (y < (this.height -1))   if (pointVal >= this.at(x, y + 1)) continue;

                // if you made it this far, it's a low point. add it to the sum
                risk += (pointVal + 1);
                console.log('found a risk point of value ' + (pointVal + 1) + ' at (' + x + ',' + y + ')');

            }
        }

        return risk;

    }


}

// EXECUTE ME
main();


