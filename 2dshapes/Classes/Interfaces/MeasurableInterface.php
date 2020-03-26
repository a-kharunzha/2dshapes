<?php


namespace Shapes\Interfaces;

/**
 * defines dimensions of matrix
 * @package Shapes
 */
interface MeasurableInterface
{
    /**
     * returns count of matrix columns
     * @return mixed
     */
    public function getWidth();

    /**
     * returns count of matrix rows
     * @return mixed
     */
    public function getHeight();
}
