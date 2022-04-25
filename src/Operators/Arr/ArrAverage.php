<?php


namespace Stankic\Evaluator\Operators\Arr;

use Stankic\Evaluator\Operator;

class ArrAverage extends Operator
{
    const SYMBOL = ".average";
    protected $isBinary = false;
    protected $precidence = 6;

    public function operate(\SplStack $stack)
    {
        $sum = 0;
        $arr = $stack->pop();  
        $items = $arr->render();
        if(!$arr || !is_array($items)){
            throw new \UnexpectedValueException ('Unexpected Value');
        }
        foreach ($arr->render() as $val) {           
            $sum += $val;
        }    
        return $sum / count($arr->render());
    }
}
