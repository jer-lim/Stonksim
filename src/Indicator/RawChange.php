<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\RawChangeBuilder;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class RawChange implements Indicator
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
    public function get(int $intervalNum, OrderTime $orderTime): float
    {
        return $this->stockPriceData->getPriceAtInterval($intervalNum)->get
            ($orderTime) -
            $this->stockPriceData->getPriceAtInterval($intervalNum - 1)->get
            ($orderTime);
    }
}