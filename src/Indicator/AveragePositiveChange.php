<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\AveragePositiveChangeBuilder;
use Jerlim\Stonksim\Interfaces\CachedIndicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class AveragePositiveChange extends CachedIndicator
{
    private StockPriceData $stockPriceData;
    private int $period;
    private PositiveChangeOnly $positiveChangeOnlyInd;

    public function __construct(AveragePositiveChangeBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->positiveChangeOnlyInd = $builder->getPositiveChangeOnlyInd();
        $this->period = $builder->getPeriod();
    }

    public static function newBuilder(): AveragePositiveChangeBuilder
    {
        return new AveragePositiveChangeBuilder();
    }

    protected function getValue(int $intervalNum, OrderTime $orderTime): float
    {
        $sum = 0;
        if ($intervalNum == $this->period) {
            for ($i = $intervalNum - $this->period + 1; $i <= $intervalNum;
                 ++$i) {
                $sum += $this->positiveChangeOnlyInd->get($i, $orderTime);
            }
        } else {
            $sum = ($this->period - 1) * $this->get($intervalNum - 1,
                                                    $orderTime);
            $sum += $this->positiveChangeOnlyInd->get($intervalNum, $orderTime);
        }
        return $sum / $this->period;
    }
}