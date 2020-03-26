<?php declare(strict_types=1);

namespace Shapes;

use Shapes\Exception\EmptyInputDataException;
use Shapes\InputReader\InputStreamReader;

class InputProcessor
{
    private $inputData = null;

    /**
     * @var InputStreamReader
     */
    private $reader;

    public function __construct($inputFilePath = null)
    {
        // check if script is called with file as argument
        if ($inputFilePath) {
            $this->reader = new InputReader\File($inputFilePath);
        } else {
            // check if data is given as standard input
            $this->reader = new InputReader\Stdin();
        }
        $this->readInputData();
    }

    /**
     * reads data from anywhere, checks if is available and stores to internal field
     *
     * @throws EmptyInputDataException
     */
    protected function readInputData()
    {
        $this->inputData = $this->reader->getData();
        // check data is available
        if (empty($this->inputData)) {
            throw new EmptyInputDataException('Empty input data');
        }
    }

    public function createInputObjects()
    {
        $lines = explode("\n", trim($this->inputData));
        // order of method calls is important!
        $wall = $this->createWallObject($lines);
        $bricks = $this->createBricksStorageObject($lines);
        return [$wall,$bricks];
    }

    /**
     * @param $lines
     *
     * @return Wall
     */
    protected function createWallObject(&$lines): Wall
    {
        // size of wall
        list($wWidth, $wHeight) = self::intArr(explode(' ', array_shift($lines)));
        // wall structure
        $matrix = [];
        for ($i = 0; $i < $wHeight; $i++) {
            $line = array_shift($lines);
            $line = substr($line, 0, $wWidth);
            $matrix[] = self::intArr(str_split($line, 1));
        }
        return new Wall($wWidth, $wHeight, $matrix);
    }

    /**
     * @param $lines
     *
     * @return BrickStorage
     */
    protected function createBricksStorageObject(&$lines): BrickStorage
    {
        // available bricks
        $brickTypesCount = intval(array_shift($lines));
        $bricks = new BrickStorage();
        for ($i = 0; $i < $brickTypesCount; $i++) {
            $line = array_shift($lines);
            list($bWeight, $bHeight, $bCount) = self::intArr(explode(' ', $line));
            $bricks->addBrick(new Brick($bWeight, $bHeight), $bCount);
        }
        return $bricks;
    }

    /**
     * converts all array members to integer
     *
     * @param array<string> $array
     *
     * @return array<int>
     */
    protected static function intArr($array): array
    {
        return array_map('intval', $array);
    }
}
