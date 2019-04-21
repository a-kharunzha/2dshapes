<?php declare(strict_types=1);

// load function and classes
require_once __DIR__ . "/functions.php";
$classesDir = __DIR__ . '/Classes/';

spl_autoload_register(function ($class) use ($classesDir) {
    $namespace = 'Shapes\\';
    if (strpos($class, $namespace) === 0) {
        $class = str_replace($namespace, '', $class);
        require_once $classesDir . $class . '.php';
    }
});


// redirect exceptions to custom error output
set_exception_handler(
    function (Throwable $exception) {
        onError($exception->getMessage());
    }
);
