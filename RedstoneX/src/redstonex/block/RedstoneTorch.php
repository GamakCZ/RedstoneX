<?php

declare(strict_types=1);

namespace redstonex\block;

use pocketmine\level\Position;
use pocketmine\math\Vector3;
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


        RedstoneX::consoleDebug("§aACTIVATING (redstone wire by torch)");


        for($x = $this->getX()-1; $x <= $this->getX()+1; $x++) {
            if($x == $this->getX()) return;
            $block = $this->getLevel()->getBlock(new Vector3($x, $this->getY(), $this->getZ()));
            if(RedstoneX::isRedstone($block) || $block instanceof Redstone || $block->getId() == RedstoneX::REDSTONE_WIRE) {
                RedstoneX::setActive($block, 15);
                RedstoneX::consoleDebug("§aACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
        }

        for($y = $this->getY(); $y <= $this->getY()+1; $y++) {
            if($y == $this->getY()) return;
            $block = $this->getLevel()->getBlock(new Vector3($this->getX(), $y, $this->getZ()));
            if(RedstoneX::isRedstone($block) || $block instanceof Redstone || $block->getId() == RedstoneX::REDSTONE_WIRE) {
                RedstoneX::setActive($block, 15);
                RedstoneX::consoleDebug("§aACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
        }
        for($z = $this->getZ()-1; $z <= $this->getZ()+1; $z++) {
            if($z == $this->getZ()) return;
            $block = $this->getLevel()->getBlock(new Vector3($this->getX(), $this->getY(), $z));
            if(RedstoneX::isRedstone($block) || $block instanceof Redstone || $block->getId() == RedstoneX::REDSTONE_WIRE) {
                RedstoneX::setActive($block, 15);
                RedstoneX::consoleDebug("§aACTIVATING found");
            }
            else {
                RedstoneX::consoleDebug("nothing found.");
            }
        }
    }
}