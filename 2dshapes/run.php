<?php declare(strict_types=1);

if (php_sapi_name() != 'cli') {
    exit('only for cli use');
}

require_once "functions.php";

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
