<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\block\Solid;
use pocketmine\level\Position;
use redstonex\RedstoneData;
use redstonex\RedstoneX;

class Redstone extends Solid {

    /** @var int $id */
    protected $id = RedstoneData::REDSTONE_WIRE;

    /** @var  $meta */
    public $meta = 0;

    /**
     * @return string
     */
    public function getName():string {
        return "Redstone";
    }

    public function onUpdate(int $type) {
        $this->activateRedstone();
        return 1;
    }

    public function activateRedstone() {
        if(!($this->meta > 1)) return;
        for($x = $this->getX()-1; $x >= $this->getX()+1; $x++) {
            if(($block = $this->getLevel()->getBlock($this->asPosition()->add($x, 0, 0)))->getId() == RedstoneData::REDSTONE_WIRE) {
                RedstoneX::setActive($block, intval($this->meta-1));
            }
        }
        for($y = $this->getY(); $y >= $this->getY()+1; $y++) {
            if(($block = $this->getLevel()->getBlock($this->asPosition()->add(0, $y, 0)))->getId() == RedstoneData::REDSTONE_WIRE) {
                RedstoneX::setActive($block, intval($this->meta-1));
            }
        }
        for($z = $this->getZ()-1; $z >= $this->getZ()+1; $z++) {
            if(($block = $this->getLevel()->getBlock($this->asPosition()->add(0, 0, $z)))->getId() == RedstoneData::REDSTONE_WIRE) {
                RedstoneX::setActive($block, intval($this->meta-1));
            }
        }
    }

    public function getHardness() : float {
        return 1;
    }
}