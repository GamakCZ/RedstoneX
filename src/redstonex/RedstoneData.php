<?php

declare(strict_types=1);

namespace redstonex;

/**
 * Interface RedstoneData
 * @package redstonex
 */
interface RedstoneData {

    // ALL
    const ALL_IDS = [124, 123, 94, 93, 76, 75];

    // BLOCKS
    const REDSTONE_LAMP_ACTIVE = 124;
    const REDSTONE_LAMP_INACTIVE = 123;
    const REDSTONE_REPEATER_ACTIVE = 94;
    const REDSTONE_REPEATER_INACTIVE = 93;
    const REDSTONE_WIRE = 55;
    const REDSTONE_TORCH_ACTIVE = 76;
    const REDSTONE_TORCH_INACTIVE = 75;

    // ITEMS
    const REDSTONE_ITEM = 331;
}