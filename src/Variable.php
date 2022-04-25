<?php

namespace Stankic\Evaluator;

abstract class Variable extends Expression
{
    
    public function isVariable()
    {
        return true;
    }
}