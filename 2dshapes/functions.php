<?php declare(strict_types=1);

/**
 * writes message to standard error stream and stops running process
 *
 * @param $message
 */
function onError($message)
{
    fwrite(STDERR, 'Error: ' . $message . "\n");
    exit();
}

/**
 * converts all array members to integer
 *
 * @param $array
 *
 * @return array
 */
function intArr($array)
{
    return array_map('intval', $array);
}

/**
 * writes message into standard output
 * @param $message
 */
function writeOutput($message)
{
    fwrite(STDOUT, $message);
}
