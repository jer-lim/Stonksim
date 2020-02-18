<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;


use Jerlim\Stonksim\Builder\StockInfoBuilder;

class StockInfo
{
    private string $ticker;
    private string $name;
    private int $lotSize;

    public function __construct(StockInfoBuilder $builder)
    {
        $this->ticker = $builder->getTicker();
        $this->name = $builder->getName();
        $this->lotSize = $builder->getLotSize();
    }

    public static function newBuilder(): StockInfoBuilder
    {
        return new StockInfoBuilder();
    }

    /**
     * @return string
     */
    public function getTicker(): string
    {
        return $this->ticker;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getLotSize(): int
    {
        return $this->lotSize;
    }

}