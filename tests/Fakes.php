<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test;


use Jerlim\Stonksim\Interfaces\StockPriceProducer;
use Jerlim\Stonksim\IntervalPrice;
use Jerlim\Stonksim\StockInfo;
use Jerlim\Stonksim\StockPriceData;
use PHPUnit\Framework\TestCase;

class Fakes extends TestCase
{
    public function fakeIntervalPrice(float $price): IntervalPrice
    {
        return IntervalPrice::newBuilder()
            ->setOpen($price)
            ->setClose($price)
            ->setHigh($price)
            ->setLow($price)
            ->setStartDateTime(new \DateTime())
            ->setEndDateTime(new \DateTime())
            ->build();
    }

    public function fakeStockInfo(): StockInfo
    {
        return StockInfo::newBuilder()
            ->setName("Test Stock")
            ->setTicker("TESTTEST")
            ->setLotSize(100)
            ->build();
    }

    public function fakeStockPriceData(int $numIntervals): StockPriceData
    {
        $intervalPrices = [];
        for ($i = 0; $i < $numIntervals; ++$i) {
            array_push($intervalPrices, $this->fakeIntervalPrice($i + 1));
        }
        $stub = $this->createStub(StockPriceProducer::class);
        $stub->method('getIntervalPrices')
            ->willReturn($intervalPrices);
        return StockPriceData::newBuilder()
            ->setStockPriceProducer($stub)
            ->setStockInfo($this->fakeStockInfo())
            ->setFirstDateTime(new \DateTime())
            ->setLastDateTime(new \DateTime())
            ->setInterval(new \DateInterval('PT0S'))
            ->build();
    }
}