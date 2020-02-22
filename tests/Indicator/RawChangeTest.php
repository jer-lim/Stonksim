<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Test\Indicator;

use Jerlim\Stonksim\Indicator\RawChange;
use Jerlim\Stonksim\OrderTime;
use Jerlim\Stonksim\Test\Fakes;
use PHPUnit\Framework\TestCase;

class RawChangeTest extends TestCase
{

    public function testGet()
    {
        $fakes = new Fakes();
        $stockPriceData = $fakes->fakeTriangularStockPriceData(3);
        $indicator = RawChange::newBuilder()
            ->setStockPriceData($stockPriceData)
            ->build();
        self::assertEquals(2, $indicator->get(1, OrderTime::AT_OPEN()));
        self::assertEquals(3, $indicator->get(2, OrderTime::AT_OPEN()));
    }
}
