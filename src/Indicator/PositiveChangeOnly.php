<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Indicator;


use Jerlim\Stonksim\Indicator\Builder\PositiveChangeOnlyBuilder;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\StockPriceData;

class PositiveChangeOnly implements Indicator
{
    private StockPriceData $stockPriceData;
    private RawChange $rawChangeInd;

    public function __construct(PositiveChangeOnlyBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->rawChangeInd = $builder->getRawChangeInd();
    }

    public static function newBuilder(): PositiveChangeOnlyBuilder
    {
        return new PositiveChangeOnlyBuilder();
    }

    /**
     * @inheritDoc
     */
    public function get(int $intervalNum, OrderTime $orderTime): float
    {
        $change = $this->rawChangeInd->get($intervalNum, $orderTime);
        if ($change > 0) return $change;
        else return 0;
    }
}