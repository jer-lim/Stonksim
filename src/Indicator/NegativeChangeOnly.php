<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\NegativeChangeOnlyBuilder;
use Jerlim\Stonksim\Interfaces\CachedIndicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class NegativeChangeOnly extends CachedIndicator
{
    private StockPriceData $stockPriceData;
    private RawChange $rawChangeInd;

    public function __construct(NegativeChangeOnlyBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->rawChangeInd = $builder->getRawChangeInd();
    }

    public static function newBuilder(): NegativeChangeOnlyBuilder
    {
        return new NegativeChangeOnlyBuilder();
    }

    /**
     * @inheritDoc
     */
    public function getValue(int $intervalNum, OrderTime $orderTime): float
    {
        $change = $this->rawChangeInd->get($intervalNum, $orderTime);
        if ($change < 0) return $change;
        else return 0;
    }
}