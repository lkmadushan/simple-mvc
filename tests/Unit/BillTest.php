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
    public function it_calculates_each_users_total_expense()
    {
        $expected = [
            'tanu' => 50,
            'kasun' => 100,
            'liam' => 100
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->expenseByUsers());
    }

    /**
     * @test
     */
    public function it_calculates_due_amount_of_each_users()
    {
        $expected = [
            'tanu' => 66.66,
            'kasun' => 25,
            'liam' => 33.33
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->dueByUsers());
    }

    /**
     * @test
     */
    public function it_calsulates_settlement_of_each_friends()
    {
        $expected = [
            'tanu' => [],
            'kasun' => [
                [
                    'from' => 'tanu',
                    'amount' => 41.66
                ],
                [
                    'from' => 'liam',
                    'amount' => 8.33
                ]
            ],
            'liam' => [
                [
                    'from' => 'tanu',
                    'amount' => 33.33,
                ]
            ]
        ];

        $this->assertEquals($expected, (new Bill($this->dataSet))->settlement());
    }
}
