<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\RawChangeBuilder;
use Jerlim\Stonksim\Interfaces\CachedIndicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class RawChange extends CachedIndicator
{
    private StockPriceData $stockPriceData;

    public function __construct(RawChangeBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
    }

    public static function newBuilder(): RawChangeBuilder
    {
        return new RawChangeBuilder();
    }

    /**
     * @inheritDoc
     */
    public function getValue(int $intervalNum, OrderTime $orderTime): float
    {
        return $this->stockPriceData->getPriceAtInterval($intervalNum)->get
            ($orderTime) -
            $this->stockPriceData->getPriceAtInterval($intervalNum - 1)->get
            ($orderTime);
    }
}