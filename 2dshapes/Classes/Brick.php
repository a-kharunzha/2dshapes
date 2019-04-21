<?php


namespace Shapes;

class Brick
{
    /**
     * @var int
     */
    private $width;
    /**
     * @var int
     */
    private $height;
    /**
     * @var int
     */
    private $quantity;

    public function __construct(int $width, int $height, int $quantity)
    {
        $this->width = $width;
        $this->height = $height;
        $this->quantity = $quantity;
    }

    public function getType()
    {
        return $this->width.'|'.$this->height;
    }
}
