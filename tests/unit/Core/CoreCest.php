<?php

namespace Tests\Unit\Core;

use UnitTester;
use Codeception\Example;

class CoreCest
{


    /**
     * CurrencyRepository class
     *
     * @var \Webkul\Core\Core
     */
    protected $core;



    /**
     * @param \UnitTester          $I
     *
     * @param \Codeception\Example $scenario
     *
     * @throws \Exception
     * @dataProvider getTaxRateScenarios
     *
     */
    public function testTaxRateAsIdentifier(UnitTester $I, Example $scenario): void
    {
        $I->assertEquals(
            $scenario['expected'],
            $I->executeFunction(
                \Webkul\Core\Core::class,
                'taxRateAsIdentifier',
                [$scenario['input']]
            )
        );
    }

    protected function getTaxRateScenarios(): array
    {
        return [
            [
                'input'    => 0,
                'expected' => '0',
            ],
            [
                'input'    => 0.01,
                'expected' => '0_01',
            ],
            [
                'input'    => .12,
                'expected' => '0_12',
            ],
            [
                'input'    => 1234.5678,
                'expected' => '1234_5678',
            ],
        ];
    }


    //    new tests
    public function testXWeekRange(UnitTester $I)
    {
        $result = $I->executeFunction(
            \Webkul\Core\Core::class,
            'xWeekRange',
            [date("Y-m-d"), 2]
        );

        $date = date("Y-m-d");
        //increment 2 days
        $mod_date = strtotime($date."+ 2 days");

        if ($mod_date === $result ){
            $I->assertEquals($this->scenario['expectedXWeekRange'], $result);
        }
        else false;
    }


    public function testIsChannelDateInInterval(UnitTester $I)
    {
        $date = date("Y-m-d");
        $result = $I->executeFunction(
            \Webkul\Core\Core::class,
            'isChannelDateInInterval',
            [$date, strtotime($date."+ 2 days")]
        );

        if ($result){
            $I->assertEquals($this->scenario['expectedIsChannelDateInInterval'], $result);
        }
        else false;
    }


    public function testFormatBasePrice(UnitTester $I)
    {
        $result = $I->executeFunction(
            \Webkul\Core\Core::class,
            'formatBasePrice',
            [99.99]
        );

        if ($result === htmlentities('99.99 ' . $this->core->getBaseCurrency())){
            $I->assertEquals($this->scenario['expectedFormatBasePrice'], $result);
        }
        else false;
    }

    public function testConvertEmptyStringsToNull(UnitTester $I)
    {
        $result = $I->executeFunction(
            \Webkul\Core\Core::class,
            'convertEmptyStringsToNull',
            [array(' ', 'test', 'null', null, '')]
        );

        if ($result[0] === null && $result[3] === null && $result[4] === null){
            $I->assertEquals($this->scenario['expectedConvertEmptyStringsToNull'], $result);
        }
        else false;
    }

    public function testArrayMerge(UnitTester $I)
    {
        $result = $I->executeFunction(
            \Webkul\Core\Core::class,
            'arrayMerge',
            [array('test1'), array('test2')]
        );

        if ($result[0] == 'test1' && $result[1] == 'test2'){
            $I->assertEquals($this->scenario['expectedConvertEmptyStringsToNull'], $result);
        }
        else false;
    }

}
