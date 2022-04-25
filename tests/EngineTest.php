<?php

namespace Stankic\Evaluator\Tests;

require_once('vendor/autoload.php');

use Stankic\Evaluator\Engine;

use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
   
    /**
     * Example test.
     *
     * @return void
     */
    public function test_expression()
    {
        $engine = new Engine();
        $this->assertEquals(1725000, $engine->evaluate(
            "total_market*market_share*selling_price",
            [
                "total_market" => 100,
                "market_share" => 0.23,
                "selling_price" => 75000
            ]

        ));
    }


    /**
     * Array test
     *
     * @return void
     */
    public function test_array()
    {
        $engine = new Engine();
        $this->assertEquals(1375, $engine->evaluate(
            "player_sales.average*5",
            [
                "player_sales" => [100, 300, 500, 200]
            ]

        ));
    }

    public function test_number()
    {

        $engine = new Engine();
        $this->assertEquals(4, $engine->evaluate(
            "8/2",
            [
                "total_market" => 100,
                "market_share" => 0.25,
                "selling_price" => [100, 200, 300]
            ]

        ));
    }
}
