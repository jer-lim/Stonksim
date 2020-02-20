<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Interfaces;

use Jerlim\Stonksim\OrderTime;

interface Indicator
{
    /**
     * Get the value of the indicator at a given interval number
     * @param int $intervalNum
     * @param OrderTime $orderTime
     * @return float
     */
    public function get(int $intervalNum, OrderTime $orderTime): float;
}