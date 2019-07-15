<?php
require __DIR__ . '/../vendor/autoload.php';

use Optimal\VatCounter;


$vatCounter = new VatCounter\VatCounter();
$vatCounter->setRound(4);
$vatCounter->setPriceWithVat(5000, 21, 1);

print_r(
    $vatCounter->getTotalPrice() . PHP_EOL
);

print_r(
    $vatCounter->getOne() . PHP_EOL
);