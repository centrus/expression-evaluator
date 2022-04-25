<?php

namespace Stankic\Evaluator\Operators\Arithmetic;

use Stankic\Evaluator\Operator;

class Multiplication extends Operator
{
    const SYMBOL = "*";
    protected $precidence = 4;

    public function operate(\SplStack $stack)
    {        
        $right = $stack->pop()->operate($stack);        
        $left = $stack->pop()->operate($stack);
        return $left * $right;
    }
}