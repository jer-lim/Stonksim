<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;

use Jerlim\Stonksim\Builder\IntervalPriceBuilder;

class IntervalPrice
{
    private float $open;
    private float $close;
    private float $high;
    private float $low;
    private \DateTime $startDateTime;
    private \DateTime $endDateTime;

    public function __construct(IntervalPriceBuilder $builder)
    {
        $this->open = $builder->getOpen();
        $this->close = $builder->getClose();
        $this->high = $builder->getHigh();
        $this->low = $builder->getLow();
        $this->startDateTime = $builder->getStartDateTime();
        $this->endDateTime = $builder->getEndDateTime();
    }

    public static function newBuilder(): IntervalPriceBuilder
    {
        return new IntervalPriceBuilder();
    }

    /**
     * @return float
     */
    public function getOpen(): float
    {
        return $this->open;
    }

    /**
     * @return float
     */
    public function getClose(): float
    {
        return $this->close;
    }

    /**
     * @return float
     */
    public function getHigh(): float
    {
        return $this->high;
    }

    /**
     * @return float
     */
    public function getLow(): float
    {
        return $this->low;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime(): \DateTime
    {
        return $this->startDateTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime(): \DateTime
    {
        return $this->endDateTime;
    }
}