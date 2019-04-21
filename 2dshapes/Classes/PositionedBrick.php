<?php


namespace Shapes;

class PositionedBrick extends Brick implements AreaInterface
{
    /**
     * @var array
     */
    private $placePoint;

    /**
     * PlacedBrick constructor.
     *
     * @param int $width
     * @param int $height
     * @param array $placePoint
     */
    public function __construct(int $width, int $height, array $placePoint)
    {
        parent::__construct($width, $height);
        // @todo: replace array with object
        $this->placePoint = $placePoint;
    }

    public function getRow()
    {
        return $this->placePoint[0];
    }

    public function getColumn()
    {
        return $this->placePoint[1];
    }
}
