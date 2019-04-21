<?php declare(strict_types=1);

function onError($message)
{
    fwrite(STDERR, 'Error: ' . $message . "\n");
    exit();
}

function intArr($array)
{
    return array_map('intval', $array);
}

function writeOutput($message){
    fwrite(STDOUT, $message);
}
