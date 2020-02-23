<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\RsiBuilder;
use Jerlim\Stonksim\Interfaces\CachedIndicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class Rsi extends CachedIndicator
{
    private StockPriceData $stockPriceData;
    private int $period;
    private RelativeStrength $relativeStrengthInd;

    public function __construct(RsiBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->period = $builder->getPeriod();
        $this->relativeStrengthInd = $builder->getRelativeStrengthInd();
    }

    public static function newBuilder(): RsiBuilder
    {
        return new RsiBuilder();
    }

    protected function getValue(int $intervalNum, OrderTime $orderTime): float
    {
        $rs = $this->relativeStrengthInd->get($intervalNum, $orderTime);
        if ($rs === INF) {
            return 100;
        } else {
            return 100 - (100 / (1 + $rs));
        }
    }
}