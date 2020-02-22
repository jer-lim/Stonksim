<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\PositiveChangeOnly;
use Jerlim\Stonksim\Indicator\RawChange;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;
use Jerlim\Stonksim\StockPriceData;

class PositiveChangeOnlyBuilder extends IndicatorBuilder
{
    private RawChange $rawChangeInd;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new PositiveChangeOnly($this);
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
     * @return PositiveChangeOnlyBuilder
     */
    public function setRawChangeInd(RawChange $rawChangeInd): PositiveChangeOnlyBuilder
    {
        $this->rawChangeInd = $rawChangeInd;
        return $this;
    }
}