<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test\Indicator;

use Jerlim\Stonksim\Indicator\StochasticRsi;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\Test\Fakes;
use \PHPUnit\Framework\TestCase;

class StochasticRsiTest extends TestCase
{

    public function testGet()
    {
        $fakes = new Fakes();
        $ascStockChartData = $fakes->fakeAscendingStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($ascStockChartData)
            ->setMoney(10000)
            ->build();
        $ind = $sim->addIndicator(StochasticRsi::newBuilder()
                                      ->setRsiPeriod(14)
                                      ->setStochasticPeriod(14));
        self::assertEquals(100.0,
                           $ind->get($sim->getInterval(), OrderTime::AT_CLOSE()));

        $descStockChartData = $fakes->fakeDescendingStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($descStockChartData)
            ->setMoney(10000)
            ->build();
        $ind = $sim->addIndicator(StochasticRsi::newBuilder()
                                      ->setRsiPeriod(14)
                                      ->setStochasticPeriod(14));
        self::assertEquals(0,
                           $ind->get($sim->getInterval(), OrderTime::AT_CLOSE()));

        $constStockChartData = $fakes->fakeConstantStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($constStockChartData)
            ->setMoney(10000)
            ->build();
        $ind = $sim->addIndicator(StochasticRsi::newBuilder()
                                      ->setRsiPeriod(14)
                                      ->setStochasticPeriod(14));
        self::assertEquals(50,
                           $ind->get($sim->getInterval(), OrderTime::AT_CLOSE()));
    }
}
