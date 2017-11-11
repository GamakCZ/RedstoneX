<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\level\Level;
use pocketmine\level\Position;
use redstonex\RedstoneX;

/**
 * Class RedstoneTorch
 * @package redstonex\block
 */
class RedstoneTorch extends \pocketmine\block\RedstoneTorch {

    /**
     * @var int
     */
    protected $id = RedstoneX::REDSTONE_TORCH_ACTIVE;

    /**
     * @return string
     */
    public function getName():string {
        return "Redstone Torch";
    }

    /**
     * @param int $type
     * @return int
     */
    public function onUpdate(int $type) {
        $this->activateRedstone();
        return $type;
    }

    public function activateRedstone() {
        RedstoneX::getInstance()->getLogger()->info("§aACTIVATING (redstone wire by torch)");
        for($x = $this->getX()-1; $x <= $this->getX()+1; $x++) {
            if(RedstoneX::isRedstone($block = $this->asPosition()->getLevel()->getBlock(Position::fromObject($this->asPosition()->add($x, 0, 0), $this->asPosition()->getLevel())))) {
                RedstoneX::setActive($block, 15);
                RedstoneX::getInstance()->getLogger()->info("§aACTIVATING found");
            }
        }
        for($y = $this->getY(); $y <= $this->getY()+1; $y++) {
            if(RedstoneX::isRedstone($block = $this->asPosition()->getLevel()->getBlock(Position::fromObject($this->asPosition()->add(0, $y, 0), $this->asPosition()->getLevel())))) {
                RedstoneX::setActive($block, 15);
                RedstoneX::getInstance()->getLogger()->info("§aACTIVATING found");
            }
        }
        for($z = $this->getZ()-1; $z <= $this->getZ()+1; $z++) {
            if(RedstoneX::isRedstone($block = $this->asPosition()->getLevel()->getBlock(Position::fromObject($this->asPosition()->add(0, 0, $z), $this->asPosition()->getLevel())))) {
                RedstoneX::setActive($block, 15);
                RedstoneX::getInstance()->getLogger()->info("§aACTIVATING found");
            }
        }
    }
}