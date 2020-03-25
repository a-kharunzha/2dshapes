<?php declare(strict_types=1);

// load function and classes
require_once __DIR__ . "/functions.php";

// create psr-4 class autoloader where namespace "Shapes" is matched to "Classes" directory
$classesDir = __DIR__ . '/Classes/';
$namespace = 'Shapes\\';
spl_autoload_register(function ($class) use ($classesDir, $namespace) {
    if (strpos($class, $namespace) === 0) {
        $class = str_replace($namespace, '', $class);
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        require_once $classesDir . $class . '.php';
    }
});

// redirect all exceptions and errors to custom error output
set_exception_handler(
    function (Throwable $exception) {
        onError($exception->getMessage());
    }
);
