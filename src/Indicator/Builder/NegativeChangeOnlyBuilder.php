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
    private RawChange $rawChangeInd;

    public function __construct(StockPriceData $stockPriceData)
    {
        parent::__construct($stockPriceData);
    }

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
            [RawChange::newBuilder($this->stockPriceData),
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
        return RawChange::newBuilder($this->stockPriceData)
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
}