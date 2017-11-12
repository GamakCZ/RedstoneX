<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\block\Block;
use pocketmine\block\Solid;
use pocketmine\block\Transparent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\Item;
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
        return "Redstone Wire";
    }

    public function onUpdate(int $type) {
        $this->activateRedstone();
        $this->deactivateRedstone();
        return $type;
    }

    public function deactivateRedstone() {
        RedstoneX::consoleDebug("§aDEACTIVING (???)");

        $signal = false;
        for($x = $this->getX()-1; $x <= $this->getX()+1; $x++) {
            for($y = $this->getY() - 1; $y <= $this->getY() + 1; $y++) {
                if($x != $this->getX()) {
                    $block = $this->getLevel()->getBlock(new Vector3($x, $this->getY(), $this->getZ()));
                    if(RedstoneX::isActive($block)) {
                        $signal = true;
                    }
                }
            }
        }

        if(RedstoneX::isActive($this->getLevel()->getBlock(new Vector3($this->getX(), $this->getY()+1, $this->getZ())))) {
            $signal = true;
        }

        for($z = $this->getZ()-1; $z <= $this->getZ()+1; $z++) {
            for($y = $this->getY() - 1; $y <= $this->getY() + 1; $y++) {
                if($z != $this->getZ()) {
                    $block = $this->getLevel()->getBlock(new Vector3($this->getX(), $this->getY(), $z));
                    if(RedstoneX::isActive($block)) {
                        $signal = true;
                    }
                }
            }
        }

        if($signal === false) {
            if(RedstoneX::isActive($this)) {
                RedstoneX::setInactive($this);
            }
            RedstoneX::consoleDebug("§aDEACTIVED BLOCK!");
        }
    }

    public function activateRedstone() {

        if ($this->meta < 1) return;

        RedstoneX::consoleDebug("ACTIVATING (redstone wire by redstone wire)");

        for ($x = $this->getX() - 1; $x <= $this->getX() + 1; $x++) {
            for($y = $this->getY() - 1; $y <= $this->getY() + 1; $y++) {
                if($x != $this->getX()) {
                    $block = $this->getLevel()->getBlock(new Vector3($x, $y, $this->getZ()));
                    if ($block->getId() == RedstoneX::REDSTONE_WIRE || $block instanceof Redstone) {
                        RedstoneX::setActive($block, intval($this->getDamage() - 1));
                        RedstoneX::consoleDebug("ACTIVATING found");
                    }
                    else {
                        RedstoneX::consoleDebug("nothing found.");
                    }
                }
            }
        }

        for ($y = $this->getY(); $y <= $this->getY() + 1; $y++) {
            if($y != $this->getY()) {
                $block = $this->getLevel()->getBlock(new Vector3($this->getX(), $y, $this->getZ()));
                if ($block->getId() == RedstoneX::REDSTONE_WIRE || $block instanceof Redstone) {
                    RedstoneX::setActive($block, intval($this->getDamage() - 1));
                    RedstoneX::consoleDebug("ACTIVATING found");
                }
                else {
                    RedstoneX::consoleDebug("nothing found.");
                }
            }
        }

        for ($z = $this->getZ() - 1; $z <= $this->getZ() + 1; $z++) {
            for($y = $this->getY() - 1; $y <= $this->getY() + 1; $y++) {
                if($z != $this->getZ()) {
                    $block = $this->getLevel()->getBlock(new Vector3($this->getX(), $y, $z));
                    if ($block->getId() == RedstoneX::REDSTONE_WIRE || $block instanceof Redstone) {
                        RedstoneX::setActive($block, intval($this->getDamage() - 1));
                        RedstoneX::consoleDebug("ACTIVATING found");
                    }
                    else {
                        RedstoneX::consoleDebug("nothing found.");
                    }
                }
            }
        }
    }

    public function getHardness(): float {
        return 0.2;
    }
}