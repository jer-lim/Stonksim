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
    // 1 2 3 4 5 6 7 8 9 10
    public function fakeAscendingStockPriceData(int $numIntervals): StockPriceData
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

    // 100 99 98 97 76 95 94 93 92 91 90
    public function fakeDescendingStockPriceData(int $numIntervals):
    StockPriceData
    {
        $intervalPrices = [];
        for ($i = 0; $i < $numIntervals; ++$i) {
            array_push($intervalPrices, $this->fakeIntervalPrice(100 - $i));
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

    // 1, 3, 6, 10, 15, 21, 28, 36, 45, 55
    public function fakeTriangularStockPriceData(int $numIntervals):
    StockPriceData
    {
        $intervalPrices = [];
        $prev = 0;
        for ($i = 1; $i < $numIntervals + 1; ++$i) {
            $prev += $i;
            array_push($intervalPrices, $this->fakeIntervalPrice($prev));
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

    // 0.5 0.5 0.5 0.5 0.5 0.5 0.5 0.5 0.5 0.5
    public function fakeConstantStockPriceData(int $numIntervals):
    StockPriceData
    {
        $intervalPrices = [];
        for ($i = 0; $i < $numIntervals; ++$i) {
            array_push($intervalPrices, $this->fakeIntervalPrice(0.5));
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

    // 1 0.5 1 0.5 1 0.5 1 0.5 1 0.5
    public function fakeTeethStockPriceData(int $numIntervals):
    StockPriceData
    {
        $intervalPrices = [];
        for ($i = 0; $i < $numIntervals; ++$i) {
            if ($i % 2 === 0) {
                $value = 1;
            } else {
                $value = 0.5;
            }
            array_push($intervalPrices, $this->fakeIntervalPrice($value));
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