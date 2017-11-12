<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\block\Block;
use pocketmine\block\Transparent;
use pocketmine\math\Vector3;
use redstonex\RedstoneX;

class Redstone extends Transparent {

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
        #ob_start(); var_dump($this->asPosition()); RedstoneX::consoleDebug(ob_get_clean());
        for ($x = $this->getX() - 1; $x <= $this->getX() + 1; $x++) {
            if($x = $this->getX()) return;
            $block = $this->getLevel()->getBlock(new Vector3($x, $this->getY(), $this->getZ()));
            if ($block->getId() == RedstoneX::REDSTONE_WIRE || $block instanceof Redstone) {
                #$block->getLevel()->setBlock($this->asVector3(), new Redstone(RedstoneX::REDSTONE_WIRE, 15));
                RedstoneX::setActive($block, intval($this->getDamage() - 1));
                RedstoneX::consoleDebug("ACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
        }
        for ($y = $this->getY(); $y <= $this->getY() + 1; $y++) {
            if($y = $this->getY()) return;
            $block = $this->getLevel()->getBlock(new Vector3($this->getX(), $y, $this->getZ()));
            if ($block->getId() == RedstoneX::REDSTONE_WIRE || $block instanceof Redstone) {
                RedstoneX::setActive($block, intval($this->getDamage() - 1));
                RedstoneX::consoleDebug("ACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
            #ob_start(); var_dump(new Vector3($this->getX(), $y, $this->getZ())); RedstoneX::consoleDebug(ob_get_clean());
        }
        for ($z = $this->getZ() - 1; $z <= $this->getZ() + 1; $z++) {
            if($z = $this->getZ()) return;
            $block = $this->getLevel()->getBlock(new Vector3($this->getX(), $this->getY(), $z));
            if ($block->getId() == RedstoneX::REDSTONE_WIRE || $block instanceof Redstone) {
                RedstoneX::setActive($block, intval($this->getDamage() - 1));
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