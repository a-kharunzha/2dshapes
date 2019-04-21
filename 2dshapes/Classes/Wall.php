<?php declare(strict_types=1);


namespace Shapes;

class Wall
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
     * @var array
     */
    private $matrix;

    public function __construct(int $width, int $height, array $matrix)
    {

        $this->width = $width;
        $this->height = $height;
        $this->matrix = $matrix;
    }
}
