<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;


use Jerlim\Stonksim\Builder\SimulatorBuilder;
use Jerlim\Stonksim\Interfaces\Indicator;
use Jerlim\Stonksim\Interfaces\IndicatorBuilder;

class Simulator
{
    private StockPriceData $stockPriceData;
    private float $money = 0;

    private int $currentInterval = 0;
    private int $position = 0;
    /**
     * @var Indicator[]
     */
    private array $indicators = [];
    private int $firstInterval = 0;
    private float $startingMoney = 0;

    public function __construct(SimulatorBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->money = $builder->getMoney();
        $this->startingMoney = $this->money;
    }

    public static function newBuilder(): SimulatorBuilder
    {
        return new SimulatorBuilder();
    }

    /**
     * Move forward to the next interval.
     * Returns false if there is no next interval.
     * @return bool
     */
    public function forward(): bool
    {
        if ($this->ended()) {
            return false;
        }

        $this->currentInterval++;
        return true;
    }

    /**
     * Whether there is a next interval
     * @return bool
     */
    public function ended(): bool
    {
        return $this->currentInterval + 1 >=
            $this->stockPriceData->getNumIntervals();
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->currentInterval;
    }

    /**
     * Buy a number of stocks. The number must match the lot size.
     * @param int $num
     * @param OrderTime $orderTime
     */
    public function buy(int $num, OrderTime $orderTime): void
    {
        if (!$this->checkLotSizeMatches($num)) {
            throw new \UnexpectedValueException("Number of stocks $num does not match the lot size.");
        }
        $price = $this->getCurrentPrice($orderTime);
        $cost = $price * $num;
        if ($cost > $this->money) {
            throw new \UnexpectedValueException("Not enough money to buy.");
        }

        $this->money -= $cost;
        $this->position += $num;
    }

    private function checkLotSizeMatches(int $num): bool
    {
        return $num % $this->stockPriceData->getStockInfo()->getLotSize() == 0;
    }

    private function getCurrentPrice(OrderTime $orderTime): float
    {
        $price = $this->stockPriceData->getPriceAtInterval
        ($this->currentInterval);
        if ($orderTime == OrderTime::AT_OPEN()) {
            return $price->getOpen();
        } elseif ($orderTime == OrderTime::AT_CLOSE()) {
            return $price->getClose();
        }
        throw new \UnexpectedValueException("Not a valid OrderTime.");
    }

    /**
     * Sell a number of stocks. Number must match the lot size.
     * @param int $num
     * @param OrderTime $orderTime
     */
    public function sell(int $num, OrderTime $orderTime): void
    {
        if (!$this->checkLotSizeMatches($num)) {
            throw new \UnexpectedValueException("Number of stocks $num does not match the lot size.");
        }
        $price = $this->getCurrentPrice($orderTime);
        $cost = $price * $num;
        if ($num > $this->position) {
            throw new \UnexpectedValueException("Not enough stocks to sell.");
        }

        $this->money += $cost;
        $this->position -= $num;
    }

    /**
     * Recursively adds an Indicator and its requirements from the
     * IndicatorBuilder. Returns the added Indicator, or an existing instance
     * if it was already present.
     * @param IndicatorBuilder $builder
     * @return Indicator
     */
    public function addIndicator(IndicatorBuilder $builder): Indicator
    {
        $requirements = $builder->requirements();
        foreach ($requirements as $requirement) {
            // Requirement should be in the format of
            // [IndicatorBuilder, Closure]
            $b = $requirement[0];
            if (!$b instanceof IndicatorBuilder) {
                $class = get_class($builder);
                throw new \UnexpectedValueException("First item in $class requirements array is not an IndicatorBuilder.");
            }
            $callback = $requirement[1];
            if (!$callback instanceof \Closure) {
                $class = get_class($builder);
                throw new \UnexpectedValueException("Second item in $class requirements array is not callable.");
            }

            // Check if there is enough data to fit the indicator
            if ($b->numPriorIntervals() >=
                $this->stockPriceData->getNumIntervals()) {
                throw new \RuntimeException("There is not enough data to fit this indicator.");
            }

            $indicator = $this->addIndicator($b);
            $callback($indicator);
        }

        // Start the simulator at a later time if needed
        // to ensure all indicators have values
        if ($this->firstInterval < $builder->numPriorIntervals()) {
            $this->firstInterval = $builder->numPriorIntervals();
            $this->setInterval($this->firstInterval);
        }

        if (!$this->hasIndicator($builder)) {
            $this->indicators[strval($builder)] = $builder->
            setStockPriceData($this->stockPriceData)->build();
        }
        return $this->indicators[strval($builder)];
    }

    public function reset(): void
    {
        $this->money = $this->startingMoney;
        $this->position = 0;
        $this->currentInterval = $this->firstInterval;
    }

    /**
     * Change the current interval to a specified number. Returns true if it
     * is a valid interval.
     * @param int $intervalNum
     * @return bool
     */
    public function setInterval(int $intervalNum): bool
    {
        if ($intervalNum < $this->stockPriceData->getNumIntervals()) {
            $this->currentInterval = $intervalNum;
            return true;
        }
        return false;
    }

    public function hasIndicator(IndicatorBuilder $builder): bool
    {
        return isset($this->indicators[strval($builder)]);
    }

    public function getIndicator(IndicatorBuilder $builder): Indicator
    {
        return $this->indicators[strval($builder)];
    }

    /**
     * @return float
     */
    public function getMoney(): float
    {
        return $this->money;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }
}