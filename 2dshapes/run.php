<?php declare(strict_types=1);

use Shapes\Brick;
use Shapes\Wall;

if (php_sapi_name() != 'cli') {
    exit('only for cli use');
}

require_once __DIR__ . "/bootstrap.php";

$currentDir = getcwd();
$inputData = null;

// check if script is called with file as argument
if (!empty($argv[1])) {
    $filePath = $currentDir . '/' . $argv[1];
    if (file_exists($filePath) && is_file($filePath)) {
        $inputData = file_get_contents($filePath);
    } else {
        onError('given file ' . $argv[1] . ' does not exists');
    }
}

// if no input as file given, try to get data from input
if (is_null($inputData)) {
    // check if data is given as standard input
    $inputData = stream_get_contents(STDIN);
}
// check data is available
if (empty($inputData)) {
    onError('Empty input data');
    exit();
}

///////////////////////
/// parsing input data
///////////////////////
$lines = explode("\n", trim($inputData));
// size of wall
list($wWidth, $wHeight) = intArr(explode(' ', array_shift($lines)));
// wall structure
$matrix = [];
for ($i = 0; $i < $wHeight; $i++) {
    $line = array_shift($lines);
    $line = substr($line, 0, $wWidth);
    $matrix[] = intArr(str_split($line, 1));
}
$wall = new Wall($wWidth, $wHeight, $matrix);
// available bricks
$brickTypesCount = intval(array_shift($lines));
$bricks = [];
for ($i = 0; $i < $brickTypesCount; $i++) {
    $line = array_shift($lines);
    list($bWeight, $bHeight, $bCount) = intArr(explode(' ', $line));
    $bricks[] = new Brick($bWeight, $bHeight, $bCount);
}
///////////////////////
/// looking for possibility of wall construction
///////////////////////
$wallIsPossible = false;


///////////////////////
/// return answer
///////////////////////
if ($wallIsPossible) {
    writeOutput('yes');
} else {
    writeOutput('no');
}
