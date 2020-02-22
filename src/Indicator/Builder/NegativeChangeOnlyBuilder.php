<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\NegativeChangeOnly;
use Jerlim\Stonksim\Indicator\RawChange;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;

class NegativeChangeOnlyBuilder extends IndicatorBuilder
{
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
}