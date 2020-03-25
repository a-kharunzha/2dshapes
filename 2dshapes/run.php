<?php declare(strict_types=1);

use Shapes\InputProcessor;
use Shapes\WallConstructor;

if (php_sapi_name() != 'cli') {
    onError('Application is for CLI use');
}
require_once __DIR__ . "/bootstrap.php";

/// reading input
$currentDir = getcwd();
$inputFilePath = !empty($argv[1]) ? ($currentDir . DIRECTORY_SEPARATOR . $argv[1]) : null;
$inputProcessor = new InputProcessor($inputFilePath);

/// parsing input data
list($wall, $bricks) = $inputProcessor->createInputObjects();

/// looking for possibility of wall construction
$wallIsPossible = false;
$wallConstructor = new WallConstructor($wall, $bricks);
$wallIsPossible = $wallConstructor->constructWall();

/// return answer
$answer = $wallIsPossible ? 'yes' : 'no';
writeOutput($answer);
