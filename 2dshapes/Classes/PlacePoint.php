<?php

namespace Shapes;

class PlacePoint implements PositionInterface
{
    /**
     * @var int
     */
    private $row;
    /**
     * @var int
     */
    private $column;

    public function __construct(int $row, int $column)
    {
        $this->row = $row;
        $this->column = $column;
    }

    /**
     * @inheritDoc
     */
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @inheritDoc
     */
    public function getColumn(): int
    {
        return $this->column;
    }

}
