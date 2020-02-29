<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Interfaces;

use Jerlim\Stonksim\IntervalPrice;

interface StockPriceProducer
{
    /**
     * @param \DateTime $firstDateTime
     * @param \DateTime $lastDateTime
     * @param \DateInterval $interval
     * @return IntervalPrice[]
     */
    public function getIntervalPrices(\DateTime $firstDateTime,
                                      \DateTime $lastDateTime,
                                      \DateInterval $interval): array;
}