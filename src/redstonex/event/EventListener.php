<?php

declare(strict_types=1);

namespace redstonex\event;

use pocketmine\block\Block;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use redstonex\block\Redstone;
use redstonex\block\RedstoneTorch;
use redstonex\RedstoneX;

class EventListener implements Listener {

    /**
     * @param BlockPlaceEvent $event
     */
    public function onPlace(BlockPlaceEvent $event) {
        switch ($event->getBlock()->getId()) {
            case Block::REDSTONE_TORCH:
                $event->getBlock()->getLevel()->setBlock($event->getBlock()->asVector3(), new RedstoneTorch(0), false, false);
                $event->setCancelled(true);
                return;
            case Block::REDSTONE_WIRE:
                $event->getBlock()->getLevel()->setBlock($event->getBlock()->asVector3(), new Redstone(55, 0, "Redstone Wire", RedstoneX::REDSTONE_ITEM));
                $event->setCancelled(true);
                return;
        }
    }
}