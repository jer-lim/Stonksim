<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test\Indicator;

use Jerlim\Stonksim\Indicator\AverageNegativeChange;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Simulator;
use Jerlim\Stonksim\Test\Fakes;
use PHPUnit\Framework\TestCase;

class AverageNegativeChangeTest extends TestCase
{

    public function testGet()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeTeethStockPriceData(10);
        $sim = Simulator::newBuilder()
            ->setMoney(10000)
            ->setStockPriceData($stockPriceData)
            ->build();
        $ind = $sim->addIndicator(AverageNegativeChange::newBuilder()
                                      ->setPeriod(3));
        self::assertEquals(-1 / 3, $ind->get($sim->getInterval(),
                                             OrderTime::AT_OPEN()));
        $sim->forward();
        self::assertEquals(-4 / 18, $ind->get($sim->getInterval(),
                                               OrderTime::AT_OPEN()));
    }
}
