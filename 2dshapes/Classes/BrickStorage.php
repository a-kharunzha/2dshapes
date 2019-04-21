<?php declare(strict_types=1);


namespace Shapes;

use Exception;

class BrickStorage
{
    private $bricks = [];

    public function addBrick(Brick $brick, int $quantity = 1): void
    {
        if ($quantity <= 0) {
            // empty brick pack - skip
            return;
        }
        $type = $brick->getType();
        if (!isset($this->bricks[$type])) {
            // @todo: create Brick collection class
            $this->bricks[$type] = [
                'shape' => $brick,
                'quantity' => 0
            ];
        }
        $this->bricks[$type]['quantity'] += $quantity;
    }

    public function getBrickTypes(): array
    {
        return array_keys($this->bricks);
    }

    public function getBrickShapeByType(string $type): Brick
    {
        $this->checkBrickTypeIsAvailable($type);
        return $this->bricks[$type]['shape'];
    }

    protected function extractBrick(Brick $brick): Brick
    {
        return $this->extractBrickByType($brick->getType());
    }

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

    public function withoutBrick(Brick $brick): BrickStorage
    {
        $newStorage = clone $this;
        $newStorage->extractBrick($brick);
        return $newStorage;
    }

    protected function checkBrickTypeIsAvailable(string $type): void
    {
        if (
            !isset($this->bricks[$type])
            ||
            $this->bricks[$type]['quantity'] <= 0
        ) {
            // @todo: custom exception class
            throw new Exception('There are no such bricks');
        }
    }
}
