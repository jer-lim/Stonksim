<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\NegativeChangeOnly;
use Jerlim\Stonksim\Indicator\RawChange;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;
use Jerlim\Stonksim\StockPriceData;

class NegativeChangeOnlyBuilder extends IndicatorBuilder
{
    private StockPriceData $stockPriceData;
    private RawChange $rawChangeInd;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new NegativeChangeOnly($this);
    }

    /**
     * @inheritDoc
     */
    public function requirements(): array
    {
        return [
            [RawChange::newBuilder(),
                fn($ind) => $this->setRawChangeInd($ind)]
        ];
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
        return RawChange::newBuilder()
            ->numPriorIntervals();
    }

    /**
     * @return RawChange
     */
    public function getRawChangeInd(): RawChange
    {
        return $this->rawChangeInd;
    }

    /**
     * @param RawChange $rawChangeInd
     * @return NegativeChangeOnlyBuilder
     */
    public function setRawChangeInd(RawChange $rawChangeInd): NegativeChangeOnlyBuilder
    {
        $this->rawChangeInd = $rawChangeInd;
        return $this;
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
     * @return NegativeChangeOnlyBuilder
     */
    public function setStockPriceData(StockPriceData $stockPriceData): NegativeChangeOnlyBuilder
    {
        $this->stockPriceData = $stockPriceData;
        return $this;
    }
}