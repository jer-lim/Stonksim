<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\RelativeStrengthBuilder;
use Jerlim\Stonksim\Interfaces\CachedIndicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class RelativeStrength extends CachedIndicator
{
    private StockPriceData $stockPriceData;
    private AveragePositiveChange $averagePositiveChangeInd;
    private AverageNegativeChange $averageNegativeChangeInd;
    private int $period;

    public function __construct(RelativeStrengthBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->averagePositiveChangeInd =
            $builder->getAveragePositiveChangeInd();
        $this->averageNegativeChangeInd =
            $builder->getAverageNegativeChangeInd();
        $this->period = $builder->getPeriod();
    }

    public static function newBuilder(): RelativeStrengthBuilder
    {
        return new RelativeStrengthBuilder();
    }

    protected function getValue(int $intervalNum, OrderTime $orderTime): float
    {
        $avPos = $this->averagePositiveChangeInd->get($intervalNum, $orderTime);
        $avNeg = $this->averageNegativeChangeInd->get($intervalNum, $orderTime);
        if ($avNeg === 0.0) {
            return INF;
        } else {
            return $avPos / -$avNeg;
        }
    }
}