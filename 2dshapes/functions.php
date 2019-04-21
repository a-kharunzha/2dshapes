<?php declare(strict_types=1);

function onError($message)
{
    fwrite(STDERR, 'Error: '.$message . "\n");
    exit();
}
