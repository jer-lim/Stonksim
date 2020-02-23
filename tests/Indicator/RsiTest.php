<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test\Indicator;

use Jerlim\Stonksim\Indicator\Rsi;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\Test\Fakes;
use \PHPUnit\Framework\TestCase;

class RsiTest extends TestCase
{

    public function testGet()
    {
        $fakes = new Fakes();
        $teethStockChartData = $fakes->fakeTeethStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($teethStockChartData)
            ->setMoney(10000)
            ->build();
        $ind = $sim->addIndicator(Rsi::newBuilder()->setPeriod(3));
        self::assertEquals(100 - (100 / 1.5),
                           $ind->get($sim->getInterval(), OrderTime::AT_CLOSE()));

        $ascStockChartData = $fakes->fakeAscendingStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($ascStockChartData)
            ->setMoney(10000)
            ->build();
        $ind = $sim->addIndicator(Rsi::newBuilder()->setPeriod(3));
        self::assertEquals(100,
                           $ind->get($sim->getInterval(), OrderTime::AT_CLOSE()));
    }
}
