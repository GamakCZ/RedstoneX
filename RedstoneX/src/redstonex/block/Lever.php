<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\item\Item;
use pocketmine\Player;

/**
 * Class Lever
 * @package redstonex\block
 */
class Lever extends \pocketmine\block\Lever {

    /**
     * Lever constructor.
     * @param int $meta
     */
    public function __construct($meta = 0) {
        parent::__construct($meta);
    }

    /**
     * @return string
     */
    public function getName(): string {
        return "Lever";
    }

    public function onActivate(Item $item, Player $player = \null): bool {
        if($this->getDamage() === 0) {
            $this->setDamage(1);
        }
        else {
            $this->setDamage(0);
        }
        return true;
    }

    public function onUpdate(int $type) {
        // TODO: implement onUpdate() method
    }
}