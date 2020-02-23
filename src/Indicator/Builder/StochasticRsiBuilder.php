<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator\Builder;


use Jerlim\Stonksim\Indicator\Rsi;
use Jerlim\Stonksim\Indicator\StochasticRsi;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;

class StochasticRsiBuilder extends IndicatorBuilder
{
    private int $rsiPeriod;
    private int $stochasticPeriod;
    private Rsi $rsiInd;

    /**
     * @inheritDoc
     */
    public function build(): Indicator
    {
        return new StochasticRsi($this);
    }

    /**
     * @inheritDoc
     */
    public function requirements(): array
    {
        return [
            [Rsi::newBuilder()->setPeriod($this->rsiPeriod),
                fn($ind) => $this->setRsiInd($ind)]
        ];
    }

    /**
     * @inheritDoc
     */
    public function numPriorIntervals(): int
    {
        return Rsi::newBuilder()->setPeriod($this->rsiPeriod)->numPriorIntervals()
            + $this->stochasticPeriod - 1;
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        return self::class . "_" . $this->rsiPeriod;
    }

    /**
     * @return int
     */
    public function getRsiPeriod(): int
    {
        return $this->rsiPeriod;
    }

    /**
     * @param int $rsiPeriod
     * @return StochasticRsiBuilder
     */
    public function setRsiPeriod(int $rsiPeriod): StochasticRsiBuilder
    {
        $this->rsiPeriod = $rsiPeriod;
        return $this;
    }

    /**
     * @return Rsi
     */
    public function getRsiInd(): Rsi
    {
        return $this->rsiInd;
    }

    /**
     * @param Rsi $rsiInd
     * @return StochasticRsiBuilder
     */
    public function setRsiInd(Rsi $rsiInd): StochasticRsiBuilder
    {
        $this->rsiInd = $rsiInd;
        return $this;
    }

    /**
     * @return int
     */
    public function getStochasticPeriod(): int
    {
        return $this->stochasticPeriod;
    }

    /**
     * @param int $stochasticPeriod
     * @return StochasticRsiBuilder
     */
    public function setStochasticPeriod(int $stochasticPeriod): StochasticRsiBuilder
    {
        $this->stochasticPeriod = $stochasticPeriod;
        return $this;
    }
}