<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Interfaces;


use Jerlim\Stonksim\StockPriceData;

abstract class IndicatorBuilder
{
    protected StockPriceData $stockPriceData;

    public function __construct(StockPriceData $stockPriceData)
    {
        $this->stockPriceData = $stockPriceData;
    }

    /**
     * Return the concrete @link Indicator
     * @return Indicator
     */
    abstract public function build(): Indicator;

    /**
     * Returns an array of array of @link IndicatorBuilder and @link \Closure
     * [IndicatorBuilder, Closure] that this indicator has a dependency on. The
     * callbacks are used to set required indicators within this builder.
     * @return array[]
     */
    abstract public function requirements(): array;

    /**
     * Returns a name for this indicator that is unique given its
     * parameters. Used to not double-add indicators.
     * @return string
     */
    abstract public function name(): string;

    /**
     * Returns the minimum number of prior intervals needed for the indicator
     * to return a legitimate result.
     * @return int
     */
    abstract public function numPriorIntervals(): int;

    /**
     * @return StockPriceData
     */
    public function getStockPriceData(): StockPriceData
    {
        return $this->stockPriceData;
    }

    /**
     * @param StockPriceData $stockPriceData
     * @return IndicatorBuilder
     */
    public function setStockPriceData(StockPriceData $stockPriceData): IndicatorBuilder
    {
        $this->stockPriceData = $stockPriceData;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name();
    }
}