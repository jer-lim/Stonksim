<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Builder;


use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\StockPriceData;

class SimulatorBuilder
{
    private StockPriceData $stockPriceData;

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

}