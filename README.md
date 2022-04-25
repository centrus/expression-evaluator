Inspired by & developed upon iSerter/expression-evaluator https://github.com/iSerter/expression-evaluator

```php
$engine = new Stankic\Evaluator\Engine();
echo $engine->evaluate("player_sales.average*5","player_sales" => [100, 300, 500, 200]);
// outputs 1375
```