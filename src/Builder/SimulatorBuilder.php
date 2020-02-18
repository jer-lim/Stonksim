<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Builder;


use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\StockPriceData;

class SimulatorBuilder
{
    private StockPriceData $stockPriceData;
    private float $money;

    public function build(): Simulator
    {
        return new Simulator($this);
    }

    /**
     * @return StockPriceData
     */
    public function getStockPriceData(): StockPriceData
    {
        return $this->stockPriceData;
    }

    /**
     * @param StockPriceData $stockPriceData
     * @return SimulatorBuilder
     */
    public function setStockPriceData(StockPriceData $stockPriceData): SimulatorBuilder
    {
        $this->stockPriceData = $stockPriceData;
        return $this;
    }

    /**
     * @return float
     */
    public function getMoney(): float
    {
        return $this->money;
    }

    /**
     * @param float $money
     * @return SimulatorBuilder
     */
    public function setMoney(float $money): SimulatorBuilder
    {
        $this->money = $money;
        return $this;
    }

}