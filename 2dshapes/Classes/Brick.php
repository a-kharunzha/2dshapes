<?php declare(strict_types=1);


namespace Shapes;

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

    public function getType()
    {
        $size = [$this->width, $this->height];
        // always consider width bigger when height even brick is rotated
        rsort($size);
        return implode('|', $size);
    }

    public function isRotatable()
    {
        return $this->width != $this->height;
    }

    public function rotate()
    {
        $temp = $this->width;
        $this->width = $this->height;
        $this->height = $temp;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    public function getMatrixString(): string
    {
        $parts = [];
        for ($i = 0; $i < $this->height; $i++) {
            $parts[] = str_repeat('1', $this->width);
        }
        return implode("\n", $parts);
    }
}
