<?php

namespace Shapes\Interfaces;

interface PositionInterface
{
    const OFFSET = 1;

    /**
     * returns OFFSET-based number of string in matrix
     * @return int
     */
    public function getRow(): int;

    /**
     * returns OFFSET-based number of column in matrix
     * @return int
     */
    public function getColumn(): int;
}
