<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Builder;

use Jerlim\Stonksim\StockInfo;

class StockInfoBuilder
{
    private string $ticker;
    private string $name;

    /**
     * @return string
     */
    public function getTicker(): string
    {
        return $this->ticker;
    }

    /**
     * @param string $ticker
     * @return StockInfoBuilder
     */
    public function setTicker(string $ticker): StockInfoBuilder
    {
        $this->ticker = $ticker;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return StockInfoBuilder
     */
    public function setName(string $name): StockInfoBuilder
    {
        $this->name = $name;
        return $this;
    }

    public function build(): StockInfo
    {
        return new StockInfo($this);
    }
}