<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\item\Tool;
use pocketmine\math\Vector3;
use redstonex\RedstoneX;

/**
 * Class RedstoneLamp
 * @package redstonex\block
 */
class RedstoneLampUnlit extends \pocketmine\block\RedstoneLamp {

    /** @var int $id */
    protected $id = RedstoneX::REDSTONE_TORCH_INACTIVE;

    /**
     * RedstoneLampUnlit constructor.
     * @param int $meta
     */
    public function __construct($meta = 0) {
        parent::__construct($meta);
    }

    /**
     * @return string
     */
    public function getName(): string {
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

    public function onUpdate(int $type) {
        $this->checkActivate();
        return $type;
    }

    public function checkActivate() {
        for($x = $this->getX() - 1; $x <= $this->getX() + 1; $x++) {
            for($y = $this->getY() - 1; $y <= $this->getY() + 1; $y++) {
                if($x !== $this->getX()) {
                    $block = $this->getLevel()->getBlock(new Vector3($x, $y, $this->getZ()));
                    if(RedstoneX::isActive($block)) {
                        $this->setActivated(true);
                    }
                }
            }
        }
        for($z = $this->getZ() - 1; $z <= $this->getZ() + 1; $z++) {
            for($y = $this->getY() - 1; $y <= $this->getY() + 1; $y++) {
                if($x !== $this->getX()) {
                    $block = $this->getLevel()->getBlock(new Vector3($x, $y, $this->getZ()));
                    if(RedstoneX::isActive($block)) {
                        $this->setActivated(true);
                    }
                }
            }
        }
    }

    /**
     * @param bool $activated
     */
    public function setActivated(bool $activated = false) {
        $activated ? $this->getLevel()->setBlock($this->asVector3(), new RedstoneLamp, true, true) : $this->getLevel()->setBlock($this->asVector3(), new RedstoneLampUnlit, true, true);
    }
}