<?php

namespace Stankic\Evaluator\Tests;

use Stankic\Evaluator\Engine;

use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_tokenize()
    {
        $expression = "2.5*total_market1*market_share2*selling_price.average";
        $values = [
            "total_market1" => 100,
            "market_share2" => 0.23,
            "selling_price" => [100, 200, 300]

        ];
        $engine = new Engine();

        $this->assertEquals( ["2.5", "*", "total_market1", "*", "market_share2", "*", "selling_price", ".average"], $engine->tokenize($expression));
    }


    // public function test_assign_variables()
    // {

    //     $expression = "2.5*total_market*market_share*selling_price.average";
    //     $values = [
    //         "total_market" => 100,
    //         "market_share" => 0.23,
    //         "selling_price" => [100, 200, 300]

    //     ];
    //     $engine = new Engine();
    //     $engine->setVariables($values);

    //     $tokens = $engine->tokenize($expression);

    //     $variables = [];

    //     foreach ($tokens as $token) {
    //         $variables[] = $engine->assignVariables($token);
    //     }

    //     $this->assertEquals(["2.5", "*", 100, "*", 0.23, "*", [100, 200, 300], ".average"], $variables);
    // }


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
