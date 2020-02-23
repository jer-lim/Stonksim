<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\AverageNegativeChange;
use Jerlim\Stonksim\Indicator\AveragePositiveChange;
use Jerlim\Stonksim\Indicator\RelativeStrength;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;

class RelativeStrengthBuilder extends IndicatorBuilder
{

    private AveragePositiveChange $averagePositiveChangeInd;
    private AverageNegativeChange $averageNegativeChangeInd;
    private int $period;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new RelativeStrength($this);
    }

    /**
     * @inheritDoc
     */
    public function requirements(): array
    {
        return [
            [AveragePositiveChange::newBuilder()->setPeriod($this->period),
                fn($ind) => $this->setAveragePositiveChangeInd($ind)],
            [AverageNegativeChange::newBuilder()->setPeriod($this->period),
                fn($ind) => $this->setAverageNegativeChangeInd($ind)]
        ];
    }

    /**
     * @inheritDoc
     */
    public function numPriorIntervals(): int
    {
        return AveragePositiveChange::newBuilder()->setPeriod($this->period)
            ->numPriorIntervals();
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return self::class . "_" . $this->period;
    }

    /**
     * @return AveragePositiveChange
     */
    public function getAveragePositiveChangeInd(): AveragePositiveChange
    {
        return $this->averagePositiveChangeInd;
    }

    /**
     * @param AveragePositiveChange $averagePositiveChangeInd
     * @return RelativeStrengthBuilder
     */
    public function setAveragePositiveChangeInd(AveragePositiveChange $averagePositiveChangeInd): RelativeStrengthBuilder
    {
        $this->averagePositiveChangeInd = $averagePositiveChangeInd;
        return $this;
    }

    /**
     * @return AverageNegativeChange
     */
    public function getAverageNegativeChangeInd(): AverageNegativeChange
    {
        return $this->averageNegativeChangeInd;
    }

    /**
     * @param AverageNegativeChange $averageNegativeChangeInd
     * @return RelativeStrengthBuilder
     */
    public function setAverageNegativeChangeInd(AverageNegativeChange $averageNegativeChangeInd): RelativeStrengthBuilder
    {
        $this->averageNegativeChangeInd = $averageNegativeChangeInd;
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
     * @return RelativeStrengthBuilder
     */
    public function setPeriod(int $period): RelativeStrengthBuilder
    {
        $this->period = $period;
        return $this;
    }
}