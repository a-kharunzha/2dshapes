<?php declare(strict_types=1);

namespace Shapes\InputReader;

class Stdin extends InputStreamReader
{
    public function __construct()
    {
        // using standard cli stream
        $this->stream = STDIN;
    }
}
