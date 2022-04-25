<?php

namespace Stankic\Evaluator\Operators\Arr;

use Stankic\Evaluator\Operator;

class ArrSum extends Operator
{
    const SYMBOL = ".sum";
    protected $isBinary = false;
    protected $precidence = 6;

    public function operate(\SplStack $stack)
    {
        $arr = $stack->pop();
        $items = $arr->render();
        if(!$arr || !is_array($items)){
            throw new \UnexpectedValueException ('Unexpected Value');
        }
        $sum = 0;
        foreach ($items as $val) {
            $sum += $val;
        }
        return $sum;
    }
}
