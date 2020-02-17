<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test;

use Jerlim\Stonksim\Interfaces\StockPriceProducer;
use Jerlim\Stonksim\IntervalPrice;
use Jerlim\Stonksim\StockInfo;
use Jerlim\Stonksim\StockPriceData;

class StockPriceDataTest extends \PHPUnit\Framework\TestCase
{

    public function testGetNumIntervals()
    {
        $stub = $this->createStub(StockPriceProducer::class);
        $stub->method('getIntervalPrices')
            ->willReturn([
                             $this->makeIntervalPrice(1.0),
                             $this->makeIntervalPrice(2.0),
                             $this->makeIntervalPrice(3.0),
                             $this->makeIntervalPrice(4.0)]);
        $stockPriceData = StockPriceData::newBuilder()
            ->setStockPriceProducer($stub)
            ->setStockInfo($this->makeStockInfo())
            ->setFirstDateTime(new \DateTime())
            ->setLastDateTime(new \DateTime())
            ->setInterval(new \DateInterval('PT0S'))
            ->build();
        static::assertEquals(4, $stockPriceData->getNumIntervals());
    }

    private function makeIntervalPrice(float $price): IntervalPrice
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

    private function makeStockInfo(): StockInfo
    {
        return StockInfo::newBuilder()
            ->setName("Test Stock")
            ->setTicker("TESTTEST")
            ->build();
    }

    public function testGetPriceAtInterval()
    {
        $stub = $this->createStub(StockPriceProducer::class);
        $stub->method('getIntervalPrices')
            ->willReturn([
                             $this->makeIntervalPrice(1.0),
                             $this->makeIntervalPrice(2.0),
                             $this->makeIntervalPrice(3.0),
                             $this->makeIntervalPrice(4.0)]);
        $stockPriceData = StockPriceData::newBuilder()
            ->setStockPriceProducer($stub)
            ->setStockInfo($this->makeStockInfo())
            ->setFirstDateTime(new \DateTime())
            ->setLastDateTime(new \DateTime())
            ->setInterval(new \DateInterval('PT0S'))
            ->build();
        static::assertEquals(3.0, $stockPriceData->getPriceAtInterval(2)->getOpen());
    }
}
