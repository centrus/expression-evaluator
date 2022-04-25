<?php

namespace Stankic\Evaluator\Operators\Arr;

use Stankic\Evaluator\Operator;

class ArrMin extends Operator
{
    const SYMBOL = ".min";
    protected $isBinary = false;
    protected $precidence = 6;

    public function operate(\SplStack $stack)
    {
        $arr = $stack->pop();
        $items = $arr->render();
        if(!$arr || !is_array($items)){
            throw new \UnexpectedValueException ('Unexpected Value');
        }
        $min = end($items);
        foreach ($items as $val) {
            if ($val < $min) $min = $val;
        }
        return $min;
    }
}
