const fs = require('fs')

/**
 * Given a filename, it loads the file in and returns an array of lines.
 * @param filename
 * @returns {*|string[]}
 */
function loadFileIntoLines(filename) {
    try {
        return fs.readFileSync(filename,'utf-8').split(/\r?\n/);
    } catch(err) {
        console.error(err);
    }
}

module.exports = { loadFileIntoLines };