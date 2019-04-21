<?php declare(strict_types=1);


namespace Shapes;

use Exception;

class Wall implements MeasurableInterface, MatrixInterface
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

    private $matrixString;

    public function __construct(int $width, int $height, array $matrix)
    {

        $this->width = $width;
        $this->height = $height;
        $this->matrix = $matrix;
        //
        $this->matrixString = $this->getMatrixString();
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    public function cellIsFilled(int $lineNum, int $cell): bool
    {
        $row = $lineNum - 1;
        $column = $cell - 1;
        if (!isset($this->matrix[$row][$column])) {
            // @todo: custom exception class
            throw new Exception('Wall cell coordinates is invalid');
        }
        return !empty($this->matrix[$row][$column]);
    }

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

    public function getMatrixString(): string
    {
        return implode("\n", array_map(function ($row) {
            return implode('', $row);
        }, $this->matrix));
    }

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
     * checks that wall does not have any bricks
     * @return bool
     */
    public function isClean()
    {
        return strpos($this->getMatrixString(), '1') === false;
    }
}
