<?php declare(strict_types=1);

namespace Shapes\InputReader;

abstract class InputStreamReader
{
    protected $stream;

    public function getData()
    {
        return stream_get_contents($this->stream);
    }
}
