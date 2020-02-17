<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Builder;


use Jerlim\Stonksim\Interfaces\StockPriceProducer;
use Jerlim\Stonksim\StockInfo;
use Jerlim\Stonksim\StockPriceData;

class StockPriceDataBuilder
{
    private StockInfo $stockInfo;
    private \DateTime $firstDateTime;
    private \DateTime $lastDateTime;
    private \DateInterval $interval;
    private StockPriceProducer $stockPriceProducer;

    public function build(): StockPriceData
    {
        return new StockPriceData($this);
    }

    /**
     * @return StockInfo
     */
    public function getStockInfo(): StockInfo
    {
        return $this->stockInfo;
    }

    /**
     * @param StockInfo $stockInfo
     * @return StockPriceDataBuilder
     */
    public function setStockInfo(StockInfo $stockInfo): StockPriceDataBuilder
    {
        $this->stockInfo = $stockInfo;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getFirstDateTime(): \DateTime
    {
        return $this->firstDateTime;
    }

    /**
     * @param \DateTime $firstDateTime
     * @return StockPriceDataBuilder
     */
    public function setFirstDateTime(\DateTime $firstDateTime): StockPriceDataBuilder
    {
        $this->firstDateTime = $firstDateTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLastDateTime(): \DateTime
    {
        return $this->lastDateTime;
    }

    /**
     * @param \DateTime $lastDateTime
     * @return StockPriceDataBuilder
     */
    public function setLastDateTime(\DateTime $lastDateTime): StockPriceDataBuilder
    {
        $this->lastDateTime = $lastDateTime;
        return $this;
    }

    /**
     * @return \DateInterval
     */
    public function getInterval(): \DateInterval
    {
        return $this->interval;
    }

    /**
     * @param \DateInterval $interval
     * @return StockPriceDataBuilder
     */
    public function setInterval(\DateInterval $interval): StockPriceDataBuilder
    {
        $this->interval = $interval;
        return $this;
    }

    /**
     * @return StockPriceProducer
     */
    public function getStockPriceProducer(): StockPriceProducer
    {
        return $this->stockPriceProducer;
    }

    /**
     * @param StockPriceProducer $stockPriceProducer
     * @return StockPriceDataBuilder
     */
    public function setStockPriceProducer(StockPriceProducer $stockPriceProducer): StockPriceDataBuilder
    {
        $this->stockPriceProducer = $stockPriceProducer;
        return $this;
    }
}