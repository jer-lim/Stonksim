<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\AverageNegativeChangeBuilder;
use Jerlim\Stonksim\Interfaces\CachedIndicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class AverageNegativeChange extends CachedIndicator
{
    private StockPriceData $stockPriceData;
    private int $period;
    private NegativeChangeOnly $negativeChangeOnlyInd;

    public function __construct(AverageNegativeChangeBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->negativeChangeOnlyInd = $builder->getNegativeChangeOnlyInd();
        $this->period = $builder->getPeriod();
    }

    public static function newBuilder(): AverageNegativeChangeBuilder {

        return new AverageNegativeChangeBuilder();
    }

    protected function getValue(int $intervalNum, OrderTime $orderTime): float
    {
        $sum = 0;
        if ($intervalNum == $this->period) {
            for ($i = $intervalNum - $this->period + 1; $i <= $intervalNum;
                 ++$i) {
                $sum += $this->negativeChangeOnlyInd->get($i, $orderTime);
            }
        } else {
            $sum = ($this->period - 1) * $this->get($intervalNum - 1,
                                                    $orderTime);
            $sum += $this->negativeChangeOnlyInd->get($intervalNum, $orderTime);
        }
        return $sum/$this->period;
    }
}