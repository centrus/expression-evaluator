<?php

namespace Stankic\Evaluator\Operators\Arr;

use Stankic\Evaluator\Operator;

class ArrMax extends Operator
{
    const SYMBOL = ".max";
    protected $isBinary = false;
    protected $precidence = 6;

    public function operate(\SplStack $stack)
    {
        $arr = $stack->pop();  
        $items = $arr->render();
        if(!$arr || !is_array($items)){
            throw new \UnexpectedValueException ('Unexpected Value');
        }
        $max = end($items);      
        foreach ($items as $val) { 
            if ($val > $max) $max = $val;
        }
        return $max;
    }
}
