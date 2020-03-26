<?php declare(strict_types=1);


namespace Shapes;

use Shapes\Exception\InvalidCellCoordinatesException;
use Shapes\Interfaces\AreaInterface;
use Shapes\Interfaces\MatrixInterface;
use Shapes\Interfaces\MeasurableInterface;

/**
 * defines size and structure of wall
 */
class Wall implements MeasurableInterface, MatrixInterface
{

    /**
     * count of columns in wall matrix
     * @var int
     */
    private $width;
    /**
     * count of rows in wall matrix
     * @var int
     */
    private $height;

    /**
     * 2-dimensional 0-based matrix of 0/1 values
     * @var array
     */
    private $matrix;

    public function __construct(int $width, int $height, array $matrix)
    {
        $this->width = $width;
        $this->height = $height;
        $this->matrix = $matrix;
    }

    /**
     * @inheritDoc
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @inheritDoc
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     *
     * @param int $lineNum 1-based number of matrix line
     * @param int $column 1-based number of matrix column
     *
     * @return bool
     * @throws InvalidCellCoordinatesException if coordinates are outside matrix
     */
    public function cellIsFilled(int $lineNum, int $column): bool
    {
        $rowOffset = $lineNum - 1;
        $columnOffset = $column - 1;
        if (!isset($this->matrix[$rowOffset][$columnOffset])) {
            throw new InvalidCellCoordinatesException('Wall cell coordinates is invalid');
        }
        return !empty($this->matrix[$rowOffset][$columnOffset]);
    }

    /**
     * cuts specified area from wall and creates new wall from that part
     *
     * ignores cells of area which are outside of initial wall
     *
     * @param AreaInterface $area
     *
     * @return Wall
     */
    public function getSubWall(AreaInterface $area): Wall
    {
        $newMatrix = [];
        for ($i = 0; $i < $area->getHeight(); $i++) {
            $offsetRow = $area->getRow() - 1 + $i;
            // if we are trying to get rows outside matrix - they must be skipped
            if (!isset($this->matrix[$offsetRow])) {
                continue;
            }
            $newMatrix[] = array_slice(
                $this->matrix[$offsetRow],
                $area->getColumn() - 1,
                $area->getWidth()
            );
        }
        return new static($area->getWidth(), $area->getHeight(), $newMatrix);
    }

    /**
     * @inheritDoc
     */
    public function getMatrixString(): string
    {
        return implode("\n", array_map(function ($row) {
            return implode('', $row);
        }, $this->matrix));
    }

    /**
     * returns new wall where given area is replaced with 0
     *
     * @param AreaInterface $area
     *
     * @return Wall
     */
    public function withClearedArea(AreaInterface $area): Wall
    {
        $newMatrix = $this->matrix;
        for ($i = 0; $i < $area->getHeight(); $i++) {
            $offsetRow = $area->getRow() - 1 + $i;
            array_splice(
                $newMatrix[$offsetRow],
                $area->getColumn() - 1,
                $area->getWidth(),
                array_fill(0, $area->getWidth(), 0)
            );
        }
        return new static($this->getWidth(), $this->getHeight(), $newMatrix);
    }

    /**
     * checks if wall does not have any bricks
     * @return bool
     */
    public function isClean()
    {
        return strpos($this->getMatrixString(), '1') === false;
    }
}
