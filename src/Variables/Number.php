<?php

namespace Stankic\Evaluator\Variables;

use Stankic\Evaluator\Variable;

class Number extends Variable
{

    public function operate(\SplStack $stack)
    {
        return $this->value;
    }
    
}