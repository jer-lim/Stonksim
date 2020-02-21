<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test;

use Jerlim\Stonksim\Indicator\NegativeChangeOnly;
use Jerlim\Stonksim\Indicator\PositiveChangeOnly;
use Jerlim\Stonksim\Indicator\RawChange;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;

class SimulatorTest extends \PHPUnit\Framework\TestCase
{

    public function testEnded()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeAscendingStockPriceData(3);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->setMoney(10000)
            ->build();
        static::assertNotTrue($sim->ended());
        $sim->forward();
        $sim->forward();
        static::assertTrue($sim->ended());
    }

    public function testForward()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeAscendingStockPriceData(3);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->setMoney(10000)
            ->build();
        static::assertTrue($sim->forward());
        static::assertTrue($sim->forward());
        static::assertNotTrue($sim->forward());
    }

    public function testSetInterval()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeAscendingStockPriceData(5);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->setMoney(10000)
            ->build();
        self::assertTrue($sim->setInterval(1));
        self::assertTrue($sim->setInterval(0));
        self::assertTrue($sim->setInterval(2));
        self::assertTrue($sim->setInterval(3));
        self::assertTrue($sim->setInterval(4));
        self::assertFalse($sim->setInterval(6));
    }


    public function testBuy()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeAscendingStockPriceData(10);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->setMoney(10000)
            ->build();
        static::assertEquals(10000, $sim->getMoney());
        static::assertEquals(0, $sim->getPosition());

        try {
            static::expectException("UnexpectedValueException");
            $sim->buy(1, OrderTime::AT_OPEN());
        } finally {
            try {
                static::expectExceptionMessage("Not enough money to buy.");
                $sim->buy(10100, OrderTime::AT_OPEN());
            } finally {
                $sim->buy(100, OrderTime::AT_OPEN());
                static::assertEquals(9900, $sim->getMoney());
                static::assertEquals(100, $sim->getPosition());
            }
        }
    }

    public function testSell()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeAscendingStockPriceData(10);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->setMoney(10000)
            ->build();
        $sim->buy(100, OrderTime::AT_OPEN());
        static::assertEquals(9900, $sim->getMoney());
        static::assertEquals(100, $sim->getPosition());

        $sim->forward();
        try {
            $this->expectException("UnexpectedValueException");
            $sim->sell(1, OrderTime::AT_OPEN());
        } finally {
            try {
                static::expectExceptionMessage("Not enough stocks to sell.");
                $sim->sell(200, OrderTime::AT_OPEN());
            } finally {
                $sim->sell(100, OrderTime::AT_OPEN());
                static::assertEquals(10100, $sim->getMoney());
                static::assertEquals(0, $sim->getPosition());
            }
        }
    }

    public function testAddIndicator()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeAscendingStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->setMoney(10000)
            ->build();
        $rawChange = $sim->addIndicator(RawChange::newBuilder());
        self::assertTrue($sim->hasIndicator(RawChange::newBuilder()));
        self::assertEquals($rawChange, $sim->getIndicator(RawChange::newBuilder
        ()));

        $positiveChange = $sim->addIndicator(PositiveChangeOnly::newBuilder
        ());
        self::assertTrue($sim->hasIndicator(RawChange::newBuilder()));
        self::assertTrue($sim->hasIndicator(PositiveChangeOnly::newBuilder()));
        self::assertEquals($rawChange, $sim->getIndicator(RawChange::newBuilder
        ()));
        self::assertEquals($positiveChange, $sim->getIndicator
        (PositiveChangeOnly::newBuilder()));

        $negativeChange = $sim->addIndicator(NegativeChangeOnly::newBuilder
        ());
        self::assertTrue($sim->hasIndicator(RawChange::newBuilder()));
        self::assertTrue($sim->hasIndicator(PositiveChangeOnly::newBuilder()));
        self::assertTrue($sim->hasIndicator(NegativeChangeOnly::newBuilder
        ()));
        self::assertEquals($rawChange, $sim->getIndicator(RawChange::newBuilder
        ()));
        self::assertEquals($positiveChange, $sim->getIndicator
        (PositiveChangeOnly::newBuilder()));
        self::assertEquals($negativeChange, $sim->getIndicator
        (NegativeChangeOnly::newBuilder()));
    }
}
