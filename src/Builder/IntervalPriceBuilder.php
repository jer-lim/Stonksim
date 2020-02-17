<?php
declare(strict_types=1);

namespace Jerlim\Stonksim\Builder;


use Jerlim\Stonksim\IntervalPrice;

class IntervalPriceBuilder
{
    private float $open;
    private float $close;
    private float $high;
    private float $low;
    private \DateTime $startDateTime;
    private \DateTime $endDateTime;

    /**
     * @param float $open
     * @return IntervalPriceBuilder
     */
    public function setOpen(float $open): IntervalPriceBuilder
    {
        $this->open = $open;
        return $this;
    }

    /**
     * @return float
     */
    public function getOpen(): float
    {
        return $this->open;
    }

    /**
     * @param float $close
     * @return IntervalPriceBuilder
     */
    public function setClose(float $close): IntervalPriceBuilder
    {
        $this->close = $close;
        return $this;
    }

    /**
     * @return float
     */
    public function getClose(): float
    {
        return $this->close;
    }

    /**
     * @param float $high
     * @return IntervalPriceBuilder
     */
    public function setHigh(float $high): IntervalPriceBuilder
    {
        $this->high = $high;
        return $this;
    }

    /**
     * @return float
     */
    public function getHigh(): float
    {
        return $this->high;
    }

    /**
     * @param float $low
     * @return IntervalPriceBuilder
     */
    public function setLow(float $low): IntervalPriceBuilder
    {
        $this->low = $low;
        return $this;
    }

    /**
     * @return float
     */
    public function getLow(): float
    {
        return $this->low;
    }

    public function build(): IntervalPrice
    {
        return new IntervalPrice($this);
    }

    /**
     * @param \DateTime $startDateTime
     * @return IntervalPriceBuilder
     */
    public function setStartDateTime(\DateTime $startDateTime): IntervalPriceBuilder
    {
        $this->startDateTime = $startDateTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDateTime(): \DateTime
    {
        return $this->startDateTime;
    }

    /**
     * @param \DateTime $endDateTime
     * @return IntervalPriceBuilder
     */
    public function setEndDateTime(\DateTime $endDateTime): IntervalPriceBuilder
    {
        $this->endDateTime = $endDateTime;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDateTime(): \DateTime
    {
        return $this->endDateTime;
    }
}