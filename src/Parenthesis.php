<?php


namespace Stankic\Evaluator;

class Parenthesis extends Expression

{

    public function isParenthesis()
    {
        return true;
    }

    public function isOpen()
    {
        return $this->value == '(';
    }

    public function operate(\SplStack $stack)
    {
    }
}
