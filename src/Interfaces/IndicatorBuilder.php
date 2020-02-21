<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Interfaces;


use Jerlim\Stonksim\StockPriceData;

abstract class IndicatorBuilder
{

    /**
     * Return the concrete @return Indicator
     * @link Indicator
     */
    abstract public function build(): Indicator;

    /**
     * Returns an array of array of @return array[]
     * @link IndicatorBuilder and @link \Closure
     * [IndicatorBuilder, Closure] that this indicator has a dependency on. The
     * callbacks are used to set required indicators within this builder.
     */
    abstract public function requirements(): array;

    /**
     * Returns the minimum number of prior intervals needed for the indicator
     * to return a legitimate result.
     * @return int
     */
    abstract public function numPriorIntervals(): int;

    abstract public function getStockPriceData(): StockPriceData;

    abstract public function setStockPriceData(StockPriceData $stockPriceData):
    IndicatorBuilder;

    public function __toString(): string
    {
        return $this->name();
    }

    /**
     * Returns a name for this indicator that is unique given its
     * parameters. Used to not double-add indicators.
     * @return string
     */
    abstract public function name(): string;
}