<?php declare(strict_types=1);

require_once __DIR__ . "/functions.php";
$classesDir = __DIR__ . '/Classes/';
$classes = scandir($classesDir);
foreach ($classes as $class) {
    if (is_file($classesDir.$class)) {
        require_once $classesDir.$class;
    }
}
