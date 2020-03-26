<?php


namespace Shapes\Interfaces;

interface MatrixInterface
{
    /**
     * returns multiline string with 0/1 cells describing matrix of wall
     * @return string
     */
    public function getMatrixString(): string;
}
