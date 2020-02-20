<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;


use MyCLabs\Enum\Enum;

/**
 * Class OrderTime
 * @package Jerlim\Stonksim
 * @method static OrderTime AT_OPEN()
 * @method static OrderTime AT_CLOSE()
 * @method static OrderTime AT_HIGH()
 * @method static OrderTime AT_LOW()
 */
class OrderTime extends Enum
{
    public const AT_OPEN = 1;
    public const AT_HIGH = 2;
    public const AT_LOW = 3;
    public const AT_CLOSE = 4;
}