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
     * Total expense amount by each user
     *
     * @return array
     */
    public function expenseByUsers()
    {
        $expense = [];

        foreach ($this->data as $item) {
            $user = $item['paid_by'];

            $expense[$user] = isset($expense[$user])
                ? $expense[$user] + $item['amount']
                : $item['amount'];
        }

        return $expense;
    }

    /**
     * Due amount of the each user
     * 
     * @return array
     */
    public function dueByUsers()
    {
        $due = [];

        foreach ($this->data as $item) {
            $users = array_unique($item['friends']);
            $share = round($item['amount'] / count($users), 2);

            array_splice($users, array_search($item['paid_by'], $users), 1);

            foreach ($users as $user) {
                $due[$user] = isset($due[$user])
                    ? $due[$user] + $share
                    : $share;
            }
        }

        return $due;
    }

    /**
     * Settlement of each user
     * 
     * @return array
     */
    public function settlement()
    {
        $settlements = [];

        $users = $this->users();
        $dueUsers = $this->dueByUsers();

        foreach ($users as $creditor) {
            $settlements[$creditor] = [];

            foreach ($dueUsers as $debtor => $due) {
                if ($creditor == $debtor) {
                    continue;
                }

                if ($dueUsers[$creditor] > $due) {
                    continue;
                }

                $owe = [
                    'from' => $debtor,
                    'amount' => $due - $dueUsers[$creditor]
                ];

                array_push($settlements[$creditor], $owe);
            }
        }

        return $settlements;
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
