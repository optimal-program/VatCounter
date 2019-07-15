<?php

namespace Optimal\VatCounter;

class VatCounter
{
    /** @var float */
    protected $onePriceWithoutVat = 0;

    /** @var float */
    protected $vat = 0;

    /** @var float */
    protected $oneVat = 0;

    /** @var float */
    protected $totalPriceWithoutVat = 0;

    /** @var float */
    protected $totalVat = 0;

    /** @var float */
    protected $count = 0;

    /** @var float */
    protected $coef = 0;

    /** @var float */
    protected $rate = 1;

    /** @var bool */
    protected $disableVat = false;

    /** @var integer */
    protected $round = 2;

    /**
     * Set price with vat
     * @param float $price
     * @param int $vat
     * @param int $count
     */
    public function setPriceWithVat($price, $vat, $count = 1, $oldPattern = false)
    {
        $price = round($price / $this->rate, $this->round);
        $this->coef = ($vat / (100 + $vat)); // od 1. 4. 2019 se nezaokrouhluje na 4. desetiná místa
        if ($oldPattern) {
            $this->coef = round($vat / (100 + $vat), 4); // starý způsob zaokrouhlování DPH
        }
        $this->count = $count;
        $this->vat = $vat;
        $this->oneVat = round($price * $this->coef, $this->round);
        $this->onePriceWithoutVat = $price - $this->oneVat;
        $this->totalPriceWithoutVat = $this->onePriceWithoutVat * $count;
        $this->totalVat = $this->oneVat * $count;
    }

    /**
     * Set disable vat => all price is without vat - for EU ("přenesená daňová povinnost DPH v rámci Evropské unie")
     * @param bool $disable
     */
    public function setDisableVat($disable = false)
    {
        $this->disableVat = $disable;
    }

    /**
     * Set price without vat
     * @param float $price
     * @param int $vat
     * @param int $count
     */
    public function setPriceWithoutVat($price, $vat, $count = 1)
    {
        $price = round($price / $this->rate, $this->round);

        $this->coef = ($vat / 100);
        $this->count = $count;
        $this->vat = $vat;

        $this->onePriceWithoutVat = round($price, $this->round);
        $this->oneVat = round($this->onePriceWithoutVat * $this->coef, $this->round);

        $this->totalPriceWithoutVat = $this->onePriceWithoutVat * $count;
        $this->totalVat = $this->oneVat * $count;
    }

    /**
     * Set rounding price - default 2 decimals
     * @param int $count
     */
    public function setRound($count = 2)
    {
        $this->round = $count;
    }

    /**
     * Set exchange rate for foreign currency
     * @param float $rate
     */
    public function setExchangeRate($rate = 1.00)
    {
        $this->rate = $rate;
    }

    /**
     * Get total count price with vat for all items
     * @return float
     */
    public function getTotalPrice()
    {
        if ($this->disableVat) {
            return $this->totalPriceWithoutVat;
        }
        return $this->totalPriceWithoutVat + $this->totalVat;

    }

    /**
     * Get total count price of vat for all items
     * @return float|int
     */
    public function getTotalVat()
    {
        if ($this->disableVat) {
            return 0;
        }
        return $this->totalVat;
    }

    /**
     * Get total count price without vat for all items
     * @return float
     */
    public function getTotalWithoutVat()
    {
        return $this->totalPriceWithoutVat;
    }

    /**
     * Get price with vat for 1 item
     * @return float
     */
    public function getOnePrice()
    {
        if ($this->disableVat) {
            return $this->onePriceWithoutVat;
        }
        return $this->onePriceWithoutVat + $this->oneVat;
    }

    /**
     * Get only vat price for 1 item
     * @return float|int
     */
    public function getOneVat()
    {
        if ($this->disableVat) {
            return 0;
        }
        return $this->oneVat;
    }

    /**
     * Get price without vat for 1 item
     * @return float
     */
    public function getOneWithoutVat()
    {
        return $this->onePriceWithoutVat;
    }

    /**
     * Get percent of vat
     * @return float|int
     */
    public function getVatPercent()
    {
        if ($this->disableVat) {
            return 0;
        }
        return $this->vat;
    }

    /**
     * Get count of items
     * @return float
     */
    public function getCount()
    {
        return $this->count;
    }

}
