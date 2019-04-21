<?php declare(strict_types=1);

namespace Shapes\InputReader;

class File extends InputStreamReader
{
    private $inputFilePath;

    /**
     * File constructor.
     *
     * @param $inputFilePath
     *
     * @throws InvalidInputFileException
     */
    public function __construct($inputFilePath)
    {
        $this->inputFilePath = $inputFilePath;
        $this->openStream();
    }

    /**
     * opens read-only stream from given file
     *
     * @throws InvalidInputFileException
     */
    private function openStream()
    {
        if (file_exists($this->inputFilePath) && is_file($this->inputFilePath)) {
            $this->stream = fopen($this->inputFilePath, 'r');
        } else {
            throw new InvalidInputFileException('File ' . $this->inputFilePath . ' does not exists');
        }
    }


}
