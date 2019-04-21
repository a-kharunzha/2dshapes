<?php declare(strict_types=1);

namespace Shapes;

class BrickStorage
{
    /** @var []Brick */
    private $bricks = [];

    /**
     * adds some quantity of brick type to storage
     *
     * two differently oriented brick with same size are considered as one type
     *
     * @param Brick $brick
     * @param int $quantity
     */
    public function addBrick(Brick $brick, int $quantity = 1): void
    {
        if ($quantity <= 0) {
            // empty brick pack - skip
            return;
        }
        $type = $brick->getType();
        if (!isset($this->bricks[$type])) {
            // @todo: create Brick collection class ?
            $this->bricks[$type] = [
                'shape' => $brick,
                'quantity' => 0
            ];
        }
        $this->bricks[$type]['quantity'] += $quantity;
    }

    /**
     * returns list of available brick types
     * @return array
     */
    public function getBrickTypes(): array
    {
        return array_keys($this->bricks);
    }

    /**
     * gives shape definition object of given type
     *
     * @param string $type
     *
     * @return Brick
     */
    public function getBrickShapeByType(string $type): Brick
    {
        $this->checkBrickTypeIsAvailable($type);
        return $this->bricks[$type]['shape'];
    }

    /**
     * extracts and returns one item of given brick from storage
     *
     * @param Brick $brick
     *
     * @return Brick
     * @throws BrickTypeNotAvailableException
     */
    protected function extractBrick(Brick $brick): Brick
    {
        return $this->extractBrickByType($brick->getType());
    }

    /**
     * extracts and returns one item of given brick type from storage
     *
     * @param string $type
     *
     * @return Brick
     */
    protected function extractBrickByType(string $type): Brick
    {
        $this->checkBrickTypeIsAvailable($type);
        $brick = $this->bricks[$type]['shape'];
        $this->bricks[$type]['quantity']--;
        if ($this->bricks[$type]['quantity'] == 0) {
            unset($this->bricks[$type]);
        }
        return $brick;
    }

    /**
     * gives copy of storage with one item of particular brick extracted
     *
     * @param Brick $brick
     *
     * @return BrickStorage
     */
    public function withoutBrick(Brick $brick): BrickStorage
    {
        $newStorage = clone $this;
        $newStorage->extractBrick($brick);
        return $newStorage;
    }

    /**
     * check if any items of given brick type is available in storage
     *
     * @param string $type
     *
     * @throws BrickTypeNotAvailableException
     */
    protected function checkBrickTypeIsAvailable(string $type): void
    {
        if (
            !isset($this->bricks[$type])
            ||
            $this->bricks[$type]['quantity'] <= 0
        ) {
            throw new BrickTypeNotAvailableException('There are no such bricks');
        }
    }
}
