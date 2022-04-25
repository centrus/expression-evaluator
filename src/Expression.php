<?php

namespace Stankic\Evaluator;

use Stankic\Evaluator\Operators\Arithmetic\Division;
use Stankic\Evaluator\Operators\Arithmetic\Modulus;
use Stankic\Evaluator\Operators\Arithmetic\Multiplication;
use Stankic\Evaluator\Operators\Arithmetic\Subtraction;
use Stankic\Evaluator\Operators\Arithmetic\Addition;
use Stankic\Evaluator\Operators\Arr\ArrAverage;
use Stankic\Evaluator\Operators\Arr\ArrMax;
use Stankic\Evaluator\Operators\Arr\ArrMin;
use Stankic\Evaluator\Operators\Arr\ArrSum;
use Stankic\Evaluator\Variables\Arr;
use Stankic\Evaluator\Variables\Number;

abstract class Expression
{

    protected $value = "";

    public function __construct($value)
    {
        $this->value = $value;
    }

    public static function factory($value)
    {

        if ($value instanceof Expression) {
            return $value;
        }

        if (is_numeric($value)) {
            return new Number($value);
        }

        if (is_array($value)) {
            return new Arr($value);
        }

        if (in_array($value, array('(', ')'))) {
            return new Parenthesis($value);
        }

        switch ($value) {
            case Addition::SYMBOL:
                return new Addition($value);
            case Subtraction::SYMBOL:
                return new Subtraction($value);
            case Multiplication::SYMBOL:
                return new Multiplication($value);
            case Division::SYMBOL:
                return new Division($value);
            case Modulus::SYMBOL:
                return new Modulus($value);

            case ArrAverage::SYMBOL:
                return new ArrAverage($value);
            case ArrMin::SYMBOL:
                return new ArrMin($value);
            case ArrMax::SYMBOL:
                return new ArrMax($value);
            case ArrSum::SYMBOL:
                return new ArrSum($value);

            default:
                throw new \InvalidArgumentException('Undefined Value ' . $value);
        }
    }


    public function isOperator()
    {
        return false;
    }

    public function isParenthesis()
    {
        return false;
    }

    public function isVariable()
    {
        return false;
    }

    // Returns expression instance value
    public function render()
    {
        return $this->value;
    }

    abstract public function operate(\SplStack $stack);
}
