<?php declare(strict_types=1);


namespace Shapes;

class WallConstructor
{
    /**
     * @var Wall
     */
    private $wall;
    /**
     * @var BrickStorage
     */
    private $bricks;

    public function __construct(Wall $wall, BrickStorage $bricks)
    {
        $this->wall = $wall;
        $this->bricks = $bricks;
    }

    public function constructWall()
    {
        // is wall is already clean, wa can "build" from any set of bricks
        if ($this->wall->isClean()) {
            return true;
        }
        // way is to try to place each brick. in two positions if rotatable
        // if is not possible to place any brick, we consider what wall construction is impossible
        foreach ($this->bricks->getBrickTypes() as $type) {
            $brick = $this->bricks->getBrickShapeByType($type);
            $placePoint = $this->getBasicPlacementPoint();
            $placedBrick = new PositionedBrick($brick->getWidth(), $brick->getHeight(), $placePoint);
            $subWallConstruct = $this->constructWithAnyBrickPosition($placedBrick);
            // if construction is successful - we can return it already
            if ($subWallConstruct) {
                return $subWallConstruct;
            }
        }
        return false;
    }

    protected function constructWithAnyBrickPosition(PositionedBrick $positionedBrick)
    {
        // placing without rotation
        $subWallConstruct = $this->placeBrickAndConstructSubWall($positionedBrick);
        // if construction was not successful and brick is rotatable - try new orientation
        if (
            !$subWallConstruct
            &&
            $positionedBrick->isRotatable()
        ) {
            $positionedBrick->rotate();
            $subWallConstruct = $this->placeBrickAndConstructSubWall($positionedBrick);
        }
        return $subWallConstruct;
    }

    protected function placeBrickAndConstructSubWall(PositionedBrick $positionedBrick)
    {
        $canBePlaced = $this->canPlaceBrick($positionedBrick);
        if (!$canBePlaced) {
            return false;
        }
        // trying to construct smaller wall, where placed brick is removed from wall and storage
        $subWall = $this->wall->withClearedArea($positionedBrick);
        // if after placing we have got empty wall we can consider that wall is constructed
        if ($subWall->isClean()) {
            return true;
        }
        $subStorage = $this->bricks->withoutBrick($positionedBrick);
        $subWallConstructor = new static($subWall, $subStorage);
        return $subWallConstructor->constructWall();
    }

    protected function getBasicPlacementPoint()
    {
        // @todo: make placement strategy configurable
        // now using top - left strategy
        for ($lineNum = 1; $lineNum <= $this->wall->getHeight(); $lineNum++) {
            for ($cell = 1; $cell <= $this->wall->getWidth(); $cell++) {
                if ($this->wall->cellIsFilled($lineNum, $cell)) {
                    return [$lineNum, $cell];
                }
            }
        }
        return [-1,-1];
    }

    private function canPlaceBrick(PositionedBrick $brick)
    {
        $areaUnderBrick = $this->wall->getSubWall($brick);
        // get from each object matrix of values as simple multirow 1/0 string and compare
        return $areaUnderBrick->getMatrixString() == $brick->getMatrixString();
    }
}
