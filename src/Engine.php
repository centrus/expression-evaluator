<?php

namespace Stankic\Evaluator;

class Engine
{
    private $variables = [];

    public function evaluate(String $expression, array $values = [])
    {
        // set variables array
        $this->setVariables($values);
        // Tokenize string to array of operands and operators
        $tokens = $this->tokenize($expression);

        // Parse tokens array to stack
        $stack = $this->parse($tokens);
        
        // calculate stack value
        while (!$stack->isEmpty() && ($operator = $stack->pop()) && $operator->isOperator()) {
            // calculate operator value and push its result back to the stack            
            $value = $operator->operate($stack);            
            
            if (!is_null($value)) {
                $stack->push(Expression::factory($value));
            }
        }

        // if expression instance is left on stack return its value, else render as string
        return $operator ? $operator->render() : $this->render($stack);
    }


    public function tokenize(String $string)
    {
        // Splits string expression by operators and ignore blank spaces
        $parts = preg_split('/(\.[a-zA-Z]+|\+|-|\(|\)|\*|\/)|\s+/', $string, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        //print_r($parts);    
        return $parts;
    }

    public function setVariables(array $values)
    {
        $this->variables = $values;
    }


    protected function parse($tokens)
    {
        // Output stack   
        $output = new \SplStack();

        // Create temporary stack for storing just operators
        $operators = new \SplStack();

        foreach ($tokens as $token) {
            // Assign value from variables to token
            $token = $this->assignVariables($token);

            // Create expression from token
            $expression = Expression::factory($token);

            if ($expression->isOperator()) {
                $this->parseOperator($expression, $output, $operators);
            } elseif ($expression->isParenthesis()) {
                $this->parseParenthesis($expression, $output, $operators);
            } else {
                $output->push($expression);
            }
        }        

        // move remaining opetators to output stack
        while (!$operators->isEmpty() && ($op = $operators->pop())) {
            // no parenthesis should be left on operators stack
            if ($op->isParenthesis()) {
                throw new \Exception('Mismatched Parenthesis');
            }
            $output->push($op);
        }

        return $output;
    }    

    protected function assignVariables($token)
    {
        // If token is a word not starting with .(reserved for array operations) or digit asign value from values array
        // This could be improved by adding support if to access speciffic element in values array but this feature is out of scope
        if (preg_match('/^(?![\.\d])\w+/', $token, $matches)) {
            return isset($this->variables[$token]) ? $this->variables[$token] : 0;
        }
        return $token;
    }

    protected function parseParenthesis(Parenthesis $expression, \SplStack $output, \SplStack $operators)
    {
        // push open parenthesis to operators stack
        if ($expression->isOpen()) {
            $operators->push($expression);
        } else {
            $closed = false;
            // if expression is closed parenthesis move operators from operators stack under this parenthesis pair to output stack
            while (!$operators->isEmpty() && ($end = $operators->pop())) {
                if ($end->isParenthesis()) {
                    $closed = true;
                    break;
                } else {
                    $output->push($end);
                }
            }
            
            if (!$closed) {
                throw new \RuntimeException('Mismatched Parenthesis');
            }
        }
    }

    protected function parseOperator(Operator $expression, \SplStack $output, \SplStack $operators)
    {
        // move operators from operators stack with higher precedence than expression to output stack
        while (!$operators->isEmpty() && ($end = $operators->top()) && $end->isOperator()) {
            if ($expression->getPrecedence() <= $end->getPrecedence()) {
                $el = $operators->pop();
                $output->push($el);
            } else {
                break;
            }
        }
        // push expression to operators stack
        $operators->push($expression);
    }

    protected function render(\SplStack $stack)
    {
        $output = '';
        while (!$stack->isEmpty() && ($el = $stack->pop())) {
            $output .= $el->render();
        }
        if ($output) {
            return $output;
        }
        throw new \Exception('Cannot render');
    }
}
