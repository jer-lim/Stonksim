<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test;

use Jerlim\Stonksim\Interfaces\StockPriceProducer;
use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\StockPriceData;

class SimulatorTest extends \PHPUnit\Framework\TestCase
{

    public function testEnded()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeStockPriceData(3);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($stockPriceData)
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
            ->build();
        static::assertTrue($sim->forward());
        static::assertTrue($sim->forward());
        static::assertNotTrue($sim->forward());
    }
}
