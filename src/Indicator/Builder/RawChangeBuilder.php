<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\RawChange;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;
use Jerlim\Stonksim\StockPriceData;

class RawChangeBuilder extends IndicatorBuilder
{
    private StockPriceData $stockPriceData;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new RawChange($this);
    }

    /**
     * @inheritDoc
     */
    public function requirements(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return self::class;
    }

    /**
     * @inheritDoc
     */
    public function numPriorIntervals(): int
    {
        return 1;
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
     * @return RawChangeBuilder
     */
    public function setStockPriceData(StockPriceData $stockPriceData): RawChangeBuilder
    {
        $this->stockPriceData = $stockPriceData;
        return $this;
    }


}