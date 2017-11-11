<?php

declare(strict_types=1);

namespace redstonex;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\plugin\PluginBase;
use redstonex\block\Redstone;
use redstonex\block\RedstoneTorch;
use redstonex\event\EventListener;

/**
 * Class RedstoneX
 * @package redstonex
 * @author VixikCZ
 */
class RedstoneX extends PluginBase implements RedstoneData {

    /** @var  EventListener $listener */
    private $listener;

    public function onEnable() {
        $this->registerBlocks();
        $this->registerEvents();
    }

    public function registerEvents() {
        $this->getServer()->getPluginManager()->registerEvents($this->listener = new EventListener, $this);
    }

    public function registerBlocks() {
        BlockFactory::registerBlock(new Redstone(self::REDSTONE_WIRE, 0, "Redstone Wire", self::REDSTONE_ITEM), true);
        BlockFactory::registerBlock(new RedstoneTorch(0), true);
    }

    /**
     * @param Block $block
     * @return bool
     */
    public static function isRedstone(Block $block) {
        return in_array(intval($block->getId()), self::ALL_IDS);
    }

    public static function setActive(Block $block, int $active = 15) {
        switch ($block->getId()) {
            case self::REDSTONE_WIRE:
                $block->setDamage($active);
                return;
            default:
                $block->setDamage(intval($block->getDamage()+$active));
                return;
        }
    }
}