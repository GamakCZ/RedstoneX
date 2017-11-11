<?php

declare(strict_types=1);

namespace redstonex\event;

use pocketmine\block\Block;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use redstonex\block\Redstone;
use redstonex\block\RedstoneTorch;
use redstonex\RedstoneX;

/**
 * Class EventListener
 * @package redstonex\event
 */
class EventListener implements Listener {

    /**
     * @param BlockPlaceEvent $event
     */
    public function onPlace(BlockPlaceEvent $event) {
        $block = $event->getBlock();
        switch ($event->getBlock()->getId()) {
            case Block::REDSTONE_TORCH:
                $event->setCancelled(true);
                $event->getBlock()->getLevel()->setBlock($event->getBlock()->asVector3(), new RedstoneTorch(0), false, false);
                if($block instanceof RedstoneTorch) {
                    RedstoneX::getInstance()->getLogger()->info("Placing block (Redstone Torch) (redstonex block)");
                    $block->activateRedstone();
                }
                else {
                    RedstoneX::getInstance()->getLogger()->info("Placing block (Redstone Torch) (pmmp block)");
                    if($event->getBlock()->getLevel()->getBlock($event->getBlock()->asVector3()) instanceof RedstoneTorch) {
                        RedstoneX::getInstance()->getLogger()->info("Placed block (Redstone Torch) (pmmp block)");
                    }
                }
                return;
            case Block::REDSTONE_WIRE:
                $event->getBlock()->getLevel()->setBlock($event->getBlock()->asVector3(), new Redstone(RedstoneX::REDSTONE_WIRE, $event->getItem()->getDamage()));
                $event->setCancelled(true);
                if($block instanceof Redstone) {
                    RedstoneX::getInstance()->getLogger()->info("Placing block (Redstone Wire) (redstonex block)");
                    $block->activateRedstone();
                }
                else {
                    RedstoneX::getInstance()->getLogger()->info("Placing block (Redstone Wire) (pmmp block)");
                }
                ob_start();
                var_dump($event->getBlock());
                $dump = ob_get_clean();
                RedstoneX::getInstance()->getLogger()->info($dump);
                return;
        }
    }
}