Inspired by & developed upon iSerter/expression-evaluator https://github.com/iSerter/expression-evaluator

## Instalation
```bash
git clone https://github.com/centrus/expression-evaluator.git
cd expression-evaluator/
composer install
```

## Run Test file
./vendor/bin/phpunit.bat tests/EngineTest.php

## Example usage
```php
$engine = new Stankic\Evaluator\Engine();

echo $engine->evaluate("total_market*market_share*selling_price", "total_market" => 100, "market_share" => 0.23, "selling_price" => 75000);
// outputs 1725000

echo $engine->evaluate("player_sales.average*5","player_sales" => [100, 300, 500, 200]);
// outputs 1375
```