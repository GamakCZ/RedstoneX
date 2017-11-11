<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\block\Transparent;
use redstonex\RedstoneData;
use redstonex\RedstoneX;

class Redstone extends Transparent {

    /** @var int $id */
    protected $id = RedstoneData::REDSTONE_WIRE;

    /** @var  $meta */
    public $meta = 0;

    public function __construct($id = Redstone::REDSTONE_WIRE, $meta = 0, $name = \null, $itemId = \null)
    {
        parent::__construct($id, $meta, $name, $itemId);
    }

    /**
     * @return string
     */
    public function getName():string {
        return "Redstone";
    }

    /*public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $facePos, Player $player = \null): bool {
        $this->activateRedstone();
        return true;
    }*/

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