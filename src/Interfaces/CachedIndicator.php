<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Interfaces;


use Jerlim\Stonksim\OrderTime;

abstract class CachedIndicator implements Indicator
{

    private array $cache = [];

    /**
     * @inheritDoc
     */
    public function get(int $intervalNum, OrderTime $orderTime): float
    {
        $this->cache[$intervalNum][$orderTime->getValue()] ??= $this->getValue
        ($intervalNum, $orderTime);
        return $this->cache[$intervalNum][$orderTime->getValue()];
    }

    abstract protected function getValue(int $intervalNum, OrderTime $orderTime): float;
}