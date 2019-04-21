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

    /**
     * looks for the way of wall construction from given brick storage
     *
     * way is to try to place each brick. in two orientations if rotatable
     * if is not possible to place any brick, we consider what wall construction is impossible
     *
     */
    public function constructWall(): bool
    {
        // is wall is already clean, wa can "build" from any set of bricks
        if ($this->wall->isClean()) {
            return true;
        }
        $placePoint = $this->getBasicPlacementPoint();
        foreach ($this->bricks->getBrickTypes() as $type) {
            $brick = $this->bricks->getBrickShapeByType($type);
            // check if we found no place
            if ($placePoint instanceof NullPlacePoint) {
                continue;
            }
            // create brick placed on found position of wall
            $placedBrick = new PositionedBrick($brick->getWidth(), $brick->getHeight(), $placePoint);
            $subWallConstruct = $this->constructWithAnyBrickOrientation($placedBrick);
            // if construction is successful - we can return it already
            if ($subWallConstruct) {
                return $subWallConstruct;
            }
        }
        return false;
    }

    /**
     * tries to place brick in two different orientations and contruct wall if it is possible
     *
     * @param PositionedBrick $positionedBrick
     *
     * @return bool
     */
    protected function constructWithAnyBrickOrientation(PositionedBrick $positionedBrick): bool
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

    /**
     * tries to place brick in given orientation and construct wall
     *
     * Way is create new wall where given brick shape is removed
     * and construct it using storage without already used brick
     *
     * @param PositionedBrick $positionedBrick
     *
     * @return bool
     */
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

    /**
     * @return PlacePoint
     */
    protected function getBasicPlacementPoint()
    {
        // @todo: make placement strategy configurable ?
        // now using top - left strategy
        for ($lineNum = 1; $lineNum <= $this->wall->getHeight(); $lineNum++) {
            for ($column = 1; $column <= $this->wall->getWidth(); $column++) {
                if ($this->wall->cellIsFilled($lineNum, $column)) {
                    return new PlacePoint($lineNum, $column);
                }
            }
        }
        return new NullPlacePoint(-1, -1);
    }

    /**
     * check if we can place given brick on it's declared position inside wall
     *
     * do not checks other orientations of brick
     *
     * @param PositionedBrick $brick
     *
     * @return bool
     */
    protected function canPlaceBrick(PositionedBrick $brick)
    {
        $areaUnderBrick = $this->wall->getSubWall($brick);
        // get from each object matrix of values as simple multirow 1/0 string and compare
        return $areaUnderBrick->getMatrixString() == $brick->getMatrixString();
    }
}
