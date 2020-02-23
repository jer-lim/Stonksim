<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test\Indicator;

use Jerlim\Stonksim\Indicator\Builder\RelativeStrengthBuilder;
use Jerlim\Stonksim\Indicator\RelativeStrength;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\Test\Fakes;
use \PHPUnit\Framework\TestCase;

class RelativeStrengthTest extends TestCase
{

    public function testGet()
    {
        $fakes = new Fakes();
        $teethStockChartData = $fakes->fakeTeethStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($teethStockChartData)
            ->setMoney(10000)
            ->build();
        $ind = $sim->addIndicator(RelativeStrength::newBuilder()->setPeriod(3));

        self::assertEquals(1 / 2, $ind->get($sim->getInterval(),
                                            OrderTime::AT_CLOSE()));
        $sim->forward();
        self::assertEquals(5 / 4, $ind->get($sim->getInterval(),
                                            OrderTime::AT_CLOSE()));

        $constStockChartData = $fakes->fakeConstantStockPriceData(50);
        $sim = Simulator::newBuilder()
            ->setStockPriceData($constStockChartData)
            ->setMoney(10000)
            ->build();
        $ind = $sim->addIndicator(RelativeStrength::newBuilder()->setPeriod(5));
        self::assertEquals(1, $ind->get($sim->getInterval(),
                                            OrderTime::AT_CLOSE()));
    }
}
