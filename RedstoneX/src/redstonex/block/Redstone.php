<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\block\Transparent;
use redstonex\RedstoneX;

class Redstone extends Transparent{

    /** @var int $id */
    protected $id = RedstoneX::REDSTONE_WIRE;

    /** @var  $meta */
    public $meta = 0;

    public function __construct($id = RedstoneX::REDSTONE_WIRE, $meta = 0, $name = "Redstone Wire", $itemId = RedstoneX::REDSTONE_ITEM) {
        parent::__construct($id, $meta, $name, $itemId);
    }

    /**
     * @return string
     */
    public function getName(): string {
        return "Redstone";
    }

    public function onUpdate(int $type) {
        $this->activateRedstone();
        return $type;
    }

    public function activateRedstone() {
        if ($this->meta < 1) return;
        RedstoneX::consoleDebug("ACTIVATING (redstone wire by redstone wire)");
        // dump debug
        ob_start(); var_dump($this->asPosition()); RedstoneX::consoleDebug(ob_get_clean());
        for ($x = $this->getX() - 1; $x <= $this->getX() + 1; $x++) {
            if (($block = $this->getLevel()->getBlock($this->asPosition()->add($x, 0, 0)))->getId() == RedstoneX::REDSTONE_WIRE) {
                $block->getLevel()->setBlock($this->asVector3(), new Redstone(RedstoneX::REDSTONE_WIRE, 15));
                RedstoneX::consoleDebug("ACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
        }
        for ($y = $this->getY(); $y <= $this->getY() + 1; $y++) {
            if (($block = $this->getLevel()->getBlock($this->asPosition()->add(0, $y, 0)))->getId() == RedstoneX::REDSTONE_WIRE) {
                RedstoneX::setActive($block, intval($this->meta - 1));
                RedstoneX::consoleDebug("ACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
        }
        for ($z = $this->getZ() - 1; $z <= $this->getZ() + 1; $z++) {
            if (($block = $this->getLevel()->getBlock($this->asPosition()->add(0, 0, $z)))->getId() == RedstoneX::REDSTONE_WIRE) {
                RedstoneX::setActive($block, intval($this->meta - 1));
                RedstoneX::consoleDebug("ACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
        }
    }

    public function getHardness(): float {
        return 0.2;
    }
}