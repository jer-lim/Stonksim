<?php
declare(strict_types=1);

namespace Jerlim\Stonksim;


use Jerlim\Stonksim\Builder\SimulatorBuilder;

class Simulator
{
    private StockPriceData $stockPriceData;
    private float $money = 0;

    private int $currentInterval = 0;
    private int $position = 0;

    public function __construct(SimulatorBuilder $builder)
    {
        $this->stockPriceData = $builder->getStockPriceData();
        $this->money = $builder->getMoney();
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
        if ($orderTime == OrderTime::AT_OPEN) {
            return $price->getOpen();
        } elseif ($orderTime == OrderTime::AT_CLOSE) {
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