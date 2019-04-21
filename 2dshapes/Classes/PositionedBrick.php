<?php

namespace Shapes;

class PositionedBrick extends Brick implements AreaInterface
{
    /**
     * @var PositionInterface
     */
    private $placePoint;

    public function __construct(int $width, int $height, PositionInterface $placePoint)
    {
        parent::__construct($width, $height);
        $this->placePoint = $placePoint;
    }

    /**
     * @inheritDoc
     */
    public function getRow(): int
    {
        return $this->placePoint->getRow();
    }

    /**
     * @inheritDoc
     */
    public function getColumn(): int
    {
        return $this->placePoint->getColumn();
    }
}
