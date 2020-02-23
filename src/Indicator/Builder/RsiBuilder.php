<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\RelativeStrength;
use Jerlim\Stonksim\Indicator\Rsi;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;

class RsiBuilder extends IndicatorBuilder
{
    private int $period;
    private RelativeStrength $relativeStrengthInd;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new Rsi($this);
    }

    /**
     * @inheritDoc
     */
    public function requirements(): array
    {
        return [
            [RelativeStrength::newBuilder()->setPeriod($this->period),
                fn($ind) => $this->setRelativeStrengthInd($ind)]
        ];
    }

    /**
     * @inheritDoc
     */
    public function numPriorIntervals(): int
    {
        return RelativeStrength::newBuilder()->setPeriod($this->period)
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
     * @return int
     */
    public function getPeriod(): int
    {
        return $this->period;
    }

    /**
     * @param int $period
     * @return RsiBuilder
     */
    public function setPeriod(int $period): RsiBuilder
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return RelativeStrength
     */
    public function getRelativeStrengthInd(): RelativeStrength
    {
        return $this->relativeStrengthInd;
    }

    /**
     * @param RelativeStrength $relativeStrengthInd
     * @return RsiBuilder
     */
    public function setRelativeStrengthInd(RelativeStrength $relativeStrengthInd): RsiBuilder
    {
        $this->relativeStrengthInd = $relativeStrengthInd;
        return $this;
    }
}