<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\block\Transparent;
use redstonex\RedstoneX;

class Redstone extends Transparent {

    /** @var int $id */
    protected $id = RedstoneX::REDSTONE_WIRE;

    /** @var  $meta */
    public $meta = 0;

    public function __construct($id = Redstone::REDSTONE_WIRE, $meta = 0, $name = \null, $itemId = \null) {
        parent::__construct($id, $meta, $name, $itemId);
    }

    /**
     * @return string
     */
    public function getName():string {
        return "Redstone";
    }

    public function onUpdate(int $type) {
        $this->activateRedstone();
        return $type;
    }

    public function activateRedstone() {
        if($this->meta < 1) return;
        RedstoneX::getInstance()->getLogger()->info("ACTIVATING!!!");
        for($x = $this->getX()-1; $x <= $this->getX()+1; $x++) {
            if(($block = $this->getLevel()->getBlock($this->asPosition()->add($x, 0, 0)))->getId() == RedstoneX::REDSTONE_WIRE) {
                $block->meta = $this->meta-1;
                RedstoneX::getInstance()->getLogger()->info("ACTIVATING (...)");
            }
        }
        for($y = $this->getY(); $y <= $this->getY()+1; $y++) {
            if(($block = $this->getLevel()->getBlock($this->asPosition()->add(0, $y, 0)))->getId() == RedstoneX::REDSTONE_WIRE) {
                RedstoneX::setActive($block, intval($this->meta-1));
            }
        }
        for($z = $this->getZ()-1; $z <= $this->getZ()+1; $z++) {
            if(($block = $this->getLevel()->getBlock($this->asPosition()->add(0, 0, $z)))->getId() == RedstoneX::REDSTONE_WIRE) {
                RedstoneX::setActive($block, intval($this->meta-1));
            }
        }
    }

    public function getHardness() : float {
        return 0.2;
    }
}