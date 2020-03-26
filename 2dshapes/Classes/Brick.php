<?php declare(strict_types=1);


namespace Shapes;

use Shapes\Interfaces\MatrixInterface;
use Shapes\Interfaces\MeasurableInterface;

class Brick implements MeasurableInterface, MatrixInterface
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * gives unique string description of brick type ignoring orientation
     *
     * two differently oriented brick with same size are considered as one type
     *
     * @return string
     */
    public function getType(): string
    {
        $size = [$this->width, $this->height];
        // always consider width bigger when height even brick is rotated
        rsort($size);
        return implode('|', $size);
    }

    /**
     * checks if brick rotation can change it's dimensions
     *
     * @return bool
     */
    public function isRotatable()
    {
        return $this->width != $this->height;
    }

    /**
     * swaps width and height of brick
     */
    public function rotate(): void
    {
        $temp = $this->width;
        $this->width = $this->height;
        $this->height = $temp;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @inheritDoc
     */
    public function getMatrixString(): string
    {
        $parts = [];
        for ($i = 0; $i < $this->height; $i++) {
            $parts[] = str_repeat('1', $this->width);
        }
        return implode("\n", $parts);
    }
}
