<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test\Indicator;

use Jerlim\Stonksim\Indicator\NegativeChangeOnly;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\Test\Fakes;
use PHPUnit\Framework\TestCase;

class NegativeChangeOnlyTest extends TestCase
{

    public function testGet()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeTeethStockPriceData(5);
        $sim = Simulator::newBuilder()
            ->setMoney(10000)
            ->setStockPriceData($stockPriceData)
            ->build();
        $ind = $sim->addIndicator(NegativeChangeOnly::newBuilder());
        self::assertEquals(-0.5, $ind->get(1, OrderTime::AT_OPEN()));
        self::assertEquals(0, $ind->get(2, OrderTime::AT_OPEN()));
        self::assertEquals(-0.5, $ind->get(3, OrderTime::AT_OPEN()));
        self::assertEquals(0, $ind->get(4, OrderTime::AT_OPEN()));
    }
}
