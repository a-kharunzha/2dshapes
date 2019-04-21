<?php declare(strict_types=1);

use Shapes\InputProcessor;
use Shapes\WallConstructor;

if (php_sapi_name() != 'cli') {
    onError('Application is for CLI use');
}
require_once __DIR__ . "/bootstrap.php";

/// reading input
$currentDir = getcwd();
$inputFilePath = !empty($argv[1]) ? ($currentDir . '/' . $argv[1]) : null;
$inputProcessor = new InputProcessor($inputFilePath);

/// parsing input data
list($wall, $bricks) = $inputProcessor->createInputObjects();

/// looking for possibility of wall construction
$wallIsPossible = false;
// @todo: divide wall into several smaller walls if there are parts which is not connected to each other on cell side
// then sort and try to solve each wall beginning from smallest. It will speed up solution for walls like test2
$wallConstructor = new WallConstructor($wall, $bricks);
$wallIsPossible = $wallConstructor->constructWall();

/// return answer
$answer = $wallIsPossible ? 'yes' : 'no';
writeOutput($answer);
