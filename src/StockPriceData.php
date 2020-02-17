<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;


use Jerlim\Stonksim\Builder\StockPriceDataBuilder;
use Jerlim\Stonksim\Interfaces\StockPriceProducer;

class StockPriceData
{
    private StockInfo $stockInfo;
    private \DateTime $firstDateTime;
    private \DateTime $lastDateTime;
    private \DateInterval $interval;
    private StockPriceProducer $stockPriceProducer;

    private int $numIntervals;

    /**
     * @var IntervalPrice[]
     */
    private array $intervalPrices = [];

    public function __construct(StockPriceDataBuilder $builder)
    {
        $this->stockInfo = $builder->getStockInfo();
        $this->firstDateTime = $builder->getFirstDateTime();
        $this->lastDateTime = $builder->getLastDateTime();
        $this->interval = $builder->getInterval();
        $this->stockPriceProducer = $builder->getStockPriceProducer();

        $this->intervalPrices = $this->stockPriceProducer->getIntervalPrices(
            $this->firstDateTime, $this->lastDateTime, $this->interval);
        $this->numIntervals = sizeof($this->intervalPrices);
    }

    public static function newBuilder(): StockPriceDataBuilder
    {
        return new StockPriceDataBuilder();
    }

    /**
     * @return \DateTime
     */
    public function getFirstDateTime(): \DateTime
    {
        return $this->firstDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getLastDateTime(): \DateTime
    {
        return $this->lastDateTime;
    }

    /**
     * @return int
     */
    public function getNumIntervals(): int
    {
        return $this->numIntervals;
    }

    /**
     * @return StockInfo
     */
    public function getStockInfo(): StockInfo
    {
        return $this->stockInfo;
    }

    /**
     * @param int $intervalNumber
     * @return IntervalPrice
     */
    public function getPriceAtInterval(int $intervalNumber): IntervalPrice
    {
        if ($intervalNumber < 0 || $intervalNumber >= $this->numIntervals) {
            throw new \OutOfRangeException("The interval number $intervalNumber does not exist between 0 and $this->numIntervals");
        }

        return $this->intervalPrices[$intervalNumber];
    }
}