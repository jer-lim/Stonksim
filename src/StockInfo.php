<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;


use Jerlim\Stonksim\Builder\StockInfoBuilder;

class StockInfo
{
    private string $ticker;
    private string $name;

    public function __construct(StockInfoBuilder $builder)
    {
        $this->ticker = $builder->getTicker();
        $this->name = $builder->getName();
    }

    public static function newBuilder(): StockInfoBuilder
    {
        return new StockInfoBuilder();
    }
}