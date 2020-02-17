<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;


use Jerlim\Stonksim\Builder\SimulatorBuilder;

class Simulator
{
    private StockPriceData $stockPriceData;

    private int $currentInterval = 0;

    public function __construct(SimulatorBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
    }

    public static function newBuilder(): SimulatorBuilder
    {
        return new SimulatorBuilder();
    }

    /**
     * Move forward to the next interval.
     * Returns false if there is no next interval.
     * @return bool
     */
    public function forward(): bool
    {
        if ($this->ended()) {
            return false;
        }

        $this->currentInterval++;
        return true;
    }

    /**
     * Whether there is a next interval
     * @return bool
     */
    public function ended(): bool
    {
        return $this->currentInterval + 1 >=
            $this->stockPriceData->getNumIntervals();
    }
}