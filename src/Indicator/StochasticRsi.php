<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\StochasticRsiBuilder;
use Jerlim\Stonksim\Interfaces\CachedIndicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class StochasticRsi extends CachedIndicator
{
    private StockPriceData $stockPriceData;
    private int $rsiPeriod;
    private int $stochasticPeriod;
    private Rsi $rsiInd;

    public function __construct(StochasticRsiBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->rsiPeriod = $builder->getRsiPeriod();
        $this->stochasticPeriod = $builder->getStochasticPeriod();
        $this->rsiInd = $builder->getRsiInd();
    }

    public static function newBuilder(): StochasticRsiBuilder
    {
        return new StochasticRsiBuilder();
    }

    protected function getValue(int $intervalNum, OrderTime $orderTime): float
    {
        $rsis = [];
        for ($i = $intervalNum - $this->stochasticPeriod + 1; $i <= $intervalNum; ++$i) {
            array_push($rsis, $this->rsiInd->get($i, $orderTime));
        }
        $max = max($rsis);
        $min = min($rsis);

        if ($max == $min) {
            return $max;
        } else {
            return ($this->rsiInd->get($intervalNum, $orderTime) - $min) /
                ($max - $min);
        }
    }
}