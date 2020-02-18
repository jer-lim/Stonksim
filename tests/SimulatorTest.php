<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test;

use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;

class SimulatorTest extends \PHPUnit\Framework\TestCase
{

    public function testEnded()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeStockPriceData(3);
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
        $stockPriceData = $fakes->fakeStockPriceData(3);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->setMoney(10000)
            ->build();
        static::assertTrue($sim->forward());
        static::assertTrue($sim->forward());
        static::assertNotTrue($sim->forward());
    }

    public function testBuy()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeStockPriceData(10);
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
        $stockPriceData = $fakes->fakeStockPriceData(10);
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
}
