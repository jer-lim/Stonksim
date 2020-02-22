<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test\Indicator;

use Jerlim\Stonksim\Indicator\AveragePositiveChange;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\Test\Fakes;

class AveragePositiveChangeTest extends \PHPUnit\Framework\TestCase
{

    public function testGet()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeTeethStockPriceData(10);
        $sim = Simulator::newBuilder()
            ->setMoney(10000)
            ->setStockPriceData($stockPriceData)
            ->build();
        $ind = $sim->addIndicator(AveragePositiveChange::newBuilder()
                                      ->setPeriod(3));
        self::assertEquals(0.5 / 3, $ind->get($sim->getInterval(),
                                              OrderTime::AT_OPEN()));
        $sim->forward();
        self::assertEquals(1 / 3, $ind->get($sim->getInterval(),
                                            OrderTime::AT_OPEN()));
    }
}
