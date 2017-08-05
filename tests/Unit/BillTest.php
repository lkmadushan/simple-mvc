<?php

namespace Tests\Unit;

use App\Bill;
use PHPUnit\Framework\TestCase;

class BillTest extends TestCase
{
    protected $dataSet = [
        [
            'day' => 1,
            'amount' => 50,
            'paid_by' => 'tanu',
            'friends' => ['kasun', 'tanu']
        ],
        [
            'day' => 2,
            'amount' => 100,
            'paid_by' => 'kasun',
            'friends' => ['kasun', 'tanu', 'liam']
        ],
        [
            'day' => 3,
            'amount' => 100,
            'paid_by' => 'liam',
            'friends' => ['liam', 'tanu', 'liam']
        ]
    ];

    /**
     * @test
     */
    public function it_throws_exception_if_data_is_not_a_multidimensional_array()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Bill([]);
    }

    /**
     * @test
     */
    public function it_throws_exception_if_data_is_invalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidData = [
            [
                'baz' => 1,
                'foo' => 50,
                'bar' => 'foo',
                'zoo' => ['bar', 'foo']
            ]
        ];

        new Bill($invalidData);
    }

    /**
     * @test
     */
    public function it_should_have_a_valid_data_set()
    {
        $expense = new Bill($this->dataSet);

        $this->assertTrue($expense->hasValidDataSet());
    }

    /**
     * @test
     */
    public function it_calculates_total_number_of_days()
    {
        $this->assertEquals(3, (new Bill($this->dataSet))->days());
    }

    /**
     * @test
     */
    public function it_calculates_total_bill_amount()
    {
        $this->assertEquals(250, (new Bill($this->dataSet))->total());
    }

    /**
     * @test
     */
    public function it_calculates_each_users_bill_spent_amount()
    {
        $expected = [
            'tanu' => 50,
            'kasun' => 100,
            'liam' => 100
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->spentByUsers());
    }

    /**
     * @test
     */
    public function it_calculates_each_users_share_of_bill()
    {
        $expected = [
            'tanu' => 91.66,
            'kasun' => 58.33,
            'liam' => 99.99,
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->shareByUsers());
    }

    /**
     * @test
     */
    public function it_calculates_each_user_diff_amount()
    {
        $expected = [
            'tanu' => -41.66,
            'kasun' => 41.67,
            'liam' => 0.01,
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->diffByUsers());
    }

    /**
     * @test
     */
    public function it_calculates_each_user_owe_amount()
    {
        $expected = [
            'tanu' => -41.66,
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->oweByUsers());
    }

    /**
     * @test
     */
    public function it_calculates_each_user_additional_paid_amount()
    {
        $expected = [
            'kasun' => 41.67,
            'liam' => 0.01,
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->additionalByUsers());
    }

    /**
     * @test
     */
    public function it_calculates_settlement_combination()
    {
        $expected = [
            'tanu->kasun' => 41.66,
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->settlement());
    }
}
