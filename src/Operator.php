<?php

namespace Stankic\Evaluator;

abstract class Operator extends Expression
{
    protected $precidence = 0;
    protected $isBinary = true;

    public function getPrecedence() {
        return $this->precidence;
    }

    public function isBinary() {
        return $this->isBinary;
    }

    public function isOperator() {
        return true;
    }
}