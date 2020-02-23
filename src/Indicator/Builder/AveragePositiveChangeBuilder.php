<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\AveragePositiveChange;
use Jerlim\Stonksim\Indicator\PositiveChangeOnly;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;
use Jerlim\Stonksim\StockPriceData;

class AveragePositiveChangeBuilder extends IndicatorBuilder
{
    private int $period;
    private PositiveChangeOnly $positiveChangeOnlyInd;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new AveragePositiveChange($this);
    }

    /**
     * @inheritDoc
     */
    public function requirements(): array
    {
        return [[PositiveChangeOnly::newBuilder(), fn ($ind) =>

        $this->setPositiveChangeOnlyInd($ind)]];
    }

    /**
     * @inheritDoc
     */
    public function numPriorIntervals(): int
    {
        return $this->period;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return self::class . "_" . $this->period;
    }

    /**
     * @return PositiveChangeOnly
     */
    public function getPositiveChangeOnlyInd(): PositiveChangeOnly
    {
        return $this->positiveChangeOnlyInd;
    }

    /**
     * @param PositiveChangeOnly $positiveChangeOnlyInd
     * @return AveragePositiveChangeBuilder
     */
    public function setPositiveChangeOnlyInd(PositiveChangeOnly $positiveChangeOnlyInd): AveragePositiveChangeBuilder
    {
        $this->positiveChangeOnlyInd = $positiveChangeOnlyInd;
        return $this;
    }

    /**
     * @return int
     */
    public function getPeriod(): int
    {
        return $this->period;
    }

    /**
     * @param int $period
     * @return AveragePositiveChangeBuilder
     */
    public function setPeriod(int $period): AveragePositiveChangeBuilder
    {
        $this->period = $period;
        return $this;
    }
}