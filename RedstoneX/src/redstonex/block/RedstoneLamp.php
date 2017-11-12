<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\item\Tool;
use redstonex\RedstoneX;

/**
 * Class RedstoneLamp
 * @package redstonex\block
 */
class RedstoneLamp extends \pocketmine\block\RedstoneLamp {

    /** @var int $id */
    protected $id = RedstoneX::REDSTONE_LAMP_INACTIVE;

    public function __construct($meta = 0) {
        parent::__construct($meta);
    }

    final public function getName(): string {
        return "Redstone Lamp";
    }

    /**
     * @return float
     */
    final public function getHardness(): float {
        return 0.3;
    }

    /**
     * @return int
     */
    final public function getToolType(): int {
        return Tool::TYPE_NONE;
    }

    /**
     * @param bool $activated
     */
    final public function setActivated(bool $activated = false) {
        $activated ? $this->id = RedstoneX::REDSTONE_LAMP_ACTIVE : $this->id = RedstoneX::REDSTONE_LAMP_INACTIVE;
    }
}