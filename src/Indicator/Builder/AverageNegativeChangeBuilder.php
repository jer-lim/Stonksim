<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\AverageNegativeChange;
use Jerlim\Stonksim\Indicator\NegativeChangeOnly;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;

class AverageNegativeChangeBuilder extends IndicatorBuilder
{
    private int $period;
    private NegativeChangeOnly $negativeChangeOnlyInd;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new AverageNegativeChange($this);
    }

    /**
     * @inheritDoc
     */
    public function requirements(): array
    {
        return [[NegativeChangeOnly::newBuilder(), fn($ind) => $this->setNegativeChangeOnlyInd($ind)]];
    }

    /**
     * @inheritDoc
     */
    public function numPriorIntervals(): int
    {
        return $this->period + 1;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return self::class . "_" . $this->period;
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
     * @return AverageNegativeChangeBuilder
     */
    public function setPeriod(int $period): AverageNegativeChangeBuilder
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return NegativeChangeOnly
     */
    public function getNegativeChangeOnlyInd(): NegativeChangeOnly
    {
        return $this->negativeChangeOnlyInd;
    }

    /**
     * @param NegativeChangeOnly $negativeChangeOnlyInd
     * @return AverageNegativeChangeBuilder
     */
    public function setNegativeChangeOnlyInd(NegativeChangeOnly $negativeChangeOnlyInd): AverageNegativeChangeBuilder
    {
        $this->negativeChangeOnlyInd = $negativeChangeOnlyInd;
        return $this;
    }
}