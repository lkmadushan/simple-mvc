<?php

namespace App;

class Bill
{
    /**
     * Keys of the data item
     *
     * @var array
     */
    protected $keys = ['day', 'amount', 'paid_by', 'friends'];

    /**
     * Settlement data set
     *
     * @var array
     */
    protected $data;

    /**
     * Bill constructor.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        if (! $this->isMultidimensionalArray($data) || ! $this->hasValidDataSet($data)) {
            $keys = implode(', ', $this->keys);

            throw new \InvalidArgumentException(
                "Data should contains only {$keys} keys."
            );
        }

        $this->data = $data;
    }

    /**
     * Check data set is valid
     *
     * @param $data
     * @return bool
     */
    public function hasValidDataSet($data = null)
    {
        $data = is_null($data) ? $this->data : $data;

        foreach ($data as $item) {
            if (count(array_diff_key(array_flip($this->keys), $item))) {
                return false;
            }
        }

        return true;
    }

    /**
     * Number of days of the bill
     *
     * @return int
     */
    public function days()
    {
        return count($this->fetchValuesByKey('day'));
    }

    /**
     * Total bill amount
     *
     * @return int
     */
    public function total()
    {
        return array_sum($this->fetchValuesByKey('amount'));
    }

    /**
     * All bill paid users
     *
     * @return array
     */
    public function users()
    {
        return array_unique($this->fetchValuesByKey('paid_by'));
    }

    /**
     * Bill amounts spent by each users
     *
     * @return array
     */
    public function spentByUsers()
    {
        $spent = [];

        foreach ($this->data as $item) {
            $user = $item['paid_by'];

            $spent[$user] = isset($spent[$user])
                ? $spent[$user] + $item['amount']
                : $item['amount'];
        }

        return $spent;
    }

    /**
     * Each user share of the bill
     *
     * @return array
     */
    public function shareByUsers()
    {
        $shares = [];

        foreach ($this->data as $item) {
            $amount = round(
                $item['amount'] / count($item['friends']), 2
            );

            foreach ($item['friends'] as $friend) {
                $shares[$friend] = isset($shares[$friend])
                    ? $shares[$friend] + $amount
                    : $amount;
            }
        }

        return $shares;
    }

    /**
     * Each user difference amount
     *
     * @return array
     */
    public function diffByUsers()
    {
        $diff = [];

        foreach ($this->spentByUsers() as $name => $amount) {
            $diff[$name] = $amount - $this->shareByUsers()[$name];
        }

        return $diff;
    }

    /**
     * Each user owe amount
     *
     * @return array
     */
    public function oweByUsers()
    {
        $owe = [];

        foreach ($this->diffByUsers() as $name => $amount) {
            if ($amount < 0) {
                $owe[$name] = $amount;
            }
        }

        return $owe;
    }

    /**
     * @return array
     */
    public function additionalByUsers()
    {
        return array_diff($this->diffByUsers(), $this->oweByUsers());
    }

    /**
     * Settlement combination
     *
     * @return array
     */
    public function settlement()
    {
        $settlement = [];

        foreach ($this->oweByUsers() as $name => $oweAmount) {
            $payable = abs($oweAmount);

            foreach ($addPaid = $this->additionalByUsers() as $addName => $addAmount) {
                if ($addAmount >= $payable) {
                    $settlement["{$name}->{$addName}"] = $payable;
                    $addPaid[$addName] = $addAmount - $payable;
                    break;
                } else {
                    $settlement["{$name}->{$addName}"] = $addAmount;
                    $payable = $payable - $addAmount;
                }
            }
        }

        return $settlement;
    }

    /**
     * Fetch data values by key
     *
     * @param $key
     * @return array
     */
    protected function fetchValuesByKey($key)
    {
        $values = [];

        foreach ($this->data as $item) {
            $values[] = $item[$key];
        }

        return $values;
    }

    /**
     * Check multidimensional array
     *
     * @param $data
     * @return bool
     */
    protected function isMultidimensionalArray($data)
    {
        return count($data) !== count($data, COUNT_RECURSIVE);
    }
}