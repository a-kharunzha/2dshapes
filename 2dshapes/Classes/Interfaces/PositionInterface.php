<?php

namespace Shapes\Interfaces;

interface PositionInterface
{
    /**
     * returns 1-based number of string in matrix
     * @return int
     */
    public function getRow(): int;

    /**
     * returns 1-based number of column in matrix
     * @return int
     */
    public function getColumn(): int;
}
