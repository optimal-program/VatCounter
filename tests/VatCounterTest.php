<?php

namespace Optimal\VatCounter;

class VatCounterTest extends \PHPUnit_Framework_TestCase
{
    private $vatCounter;

    protected function setUp()
    {
        $this->vatCounter = new VatCounter();
    }

    public function testGetTotalPrice()
    {
        $this->vatCounter->setPriceWithVat(605, 21, 10);
        $this->assertSame(6050, intval($this->vatCounter->getTotalPrice()));

        $this->vatCounter->setPriceWithoutVat(500, 21, 10);
        $this->assertSame(6050, intval($this->vatCounter->getTotalPrice()));

        $this->vatCounter->setPriceWithVat(24200, 21, 2);
        $this->assertSame(48400, intval($this->vatCounter->getTotalPrice()));

        $this->vatCounter->setPriceWithoutVat(20000, 21, 1);
        $this->assertSame(24200, intval($this->vatCounter->getTotalPrice()));

        $this->vatCounter->setPriceWithVat(500, 15, 5);
        $this->vatCounter->setDisableVat(true);
        $this->assertSame(2173.9, $this->vatCounter->getTotalPrice());
    }

    public function testSetExchangeRate()
    {
        $this->vatCounter->setExchangeRate(25.33);
        $this->vatCounter->setPriceWithVat(50, 21, 5);

        $this->assertSame(9.85, $this->vatCounter->getTotalPrice());
        $this->assertSame(0.34, $this->vatCounter->getOneVat());
        $this->vatCounter->setExchangeRate(1);
    }

    public function testSetRound()
    {
        $this->vatCounter->setRound(4);
        $this->vatCounter->setPriceWithVat(5000, 21, 1);
        $this->assertSame(867.7686, $this->vatCounter->getTotalVat());
        $this->vatCounter->setRound(2);
    }

    public function testGetTotalVat()
    {
        $this->vatCounter->setPriceWithVat(5000, 21, 1);
        $this->assertSame(867.77, $this->vatCounter->getTotalVat());
    }

    public function testGetTotalVatOldPattern()
    {
        $this->vatCounter->setPriceWithVat(5000, 21, 1, true);
        $this->assertSame(868.0, $this->vatCounter->getTotalVat());
    }

    public function testGetTotalWithoutVat()
    {
        $this->vatCounter->setPriceWithVat(5000, 21, 3);
        $this->assertSame(2603.31, $this->vatCounter->getTotalVat());
    }

    public function testGetOnePrice()
    {
        $this->vatCounter->setPriceWithVat(500, 21, 3);
        $this->assertSame(500.0, $this->vatCounter->getOnePrice());
    }

    public function testGetOneVat()
    {
        $this->vatCounter->setPriceWithVat(500, 21, 3);
        $this->assertSame(86.78, $this->vatCounter->getOneVat());
    }

    public function getOneWithoutVat()
    {
        $this->vatCounter->setPriceWithVat(500, 21, 3);
        $this->assertSame(413.22, $this->vatCounter->getOneWithoutVat());
    }

    public function testGetVatPercent()
    {
        $this->vatCounter->setPriceWithVat(500, 21, 3);
        $this->assertSame(21, $this->vatCounter->getVatPercent());
    }

    public function testGetCount()
    {
        $this->vatCounter->setPriceWithVat(500, 21, 3);
        $this->assertSame(3, $this->vatCounter->getCount());
    }
}
