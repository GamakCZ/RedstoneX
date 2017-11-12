<?php

declare(strict_types=1);

namespace redstonex;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\plugin\PluginBase;
use redstonex\block\Redstone;
use redstonex\block\RedstoneLamp;
use redstonex\block\RedstoneTorch;
use redstonex\event\EventListener;

/**
 * Class RedstoneX
 * @package redstonex
 * @author VixikCZ
 */
class RedstoneX extends PluginBase implements RedstoneData {

    /** @var  RedstoneX $instance */
    private static $instance;

    /** @var  EventListener $listener */
    private $listener;

    /** @var bool $debug */
    private static $debug = true;

    public function onEnable() {
        self::$instance = $this;
        $this->registerBlocks();
        $this->registerEvents();
    }

    public function registerEvents() {
        $this->getServer()->getPluginManager()->registerEvents($this->listener = new EventListener, $this);
    }

    public function registerBlocks() {

        /** @var Block[] $blocks */
        $blocks = [
            new Redstone(self::REDSTONE_WIRE, 0, "Redstone Wire", self::REDSTONE_ITEM),
            new RedstoneTorch(0),
            new RedstoneLamp(0)

        ];

        // OLD API SUPPORT
        try {
            if(class_exists(BlockFactory::class)) {
                foreach ($blocks as $block) {
                    BlockFactory::registerBlock($block);
                }
            }
            else {
                goto e;
            }
        }
        catch (\Exception $exception) {
            e:
            foreach ($blocks as $block) {
                Block::registerBlock($block);
            }
        }
    }

    /**
     * @param string $debug
     */
    public static function consoleDebug(string $debug) {
        if(self::$debug) self::getInstance()->getLogger()->info($debug);
    }

    /**
     * @param Block $block
     * @return bool
     */
    public static function isRedstone(Block $block) {
        return in_array(intval($block->getId()), self::ALL_IDS);
    }

    /**
     * @return RedstoneX $instance
     */
    public static function getInstance():RedstoneX {
        return self::$instance;
    }

    /**
     * @param Block $block
     */
    public static function setInactive(Block $block) {
        if($block->getId() == self::REDSTONE_WIRE || $block instanceof Redstone) {
            $block->getLevel()->setBlock($block->asVector3(), new Redstone);
        }
        else {
            $block->getLevel()->setBlockIdAt($block->getY(), $block->getY(), $block->getZ(), $block->getId());
            $block->getLevel()->setBlockDataAt($block->getY(), $block->getY(), $block->getZ(), 0);
        }
    }

    /**
     * @param Block $block
     * @param int $active
     */
    public static function setActive(Block $block, int $active = 15) {
        switch ($block->getId()) {
            case self::REDSTONE_WIRE:
                if($block->getDamage() < $active) {
                    $block->getLevel()->setBlock($block->asVector3(), new Redstone(RedstoneX::REDSTONE_WIRE, $active, "Redstone Wire", RedstoneX::REDSTONE_ITEM));
                }
                return;
            default:
                if($block->getDamage() < $active) {
                    #$block->setDamage(intval($block->getDamage()+$active));
                    $block->getLevel()->setBlock($block->asVector3(), $block, true, true);
                }
                return;
        }
    }

    /**
     * @param Block $block
     * @return bool
     */
    public static function isActive(Block $block, $num = 0): bool {
        $return = false;
        switch ($block->getId()) {
            case self::REDSTONE_WIRE:
                if($block->getDamage() > 1) $return = true;
                break;
            case self::REDSTONE_TORCH_ACTIVE:
                $return = true;
                break;
        }
        return $return;
    }
}