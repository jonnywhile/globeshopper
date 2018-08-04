<?php namespace App\Domain\Requests;


use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;

class PriceRange
{
    use PropertiesTrait, JsonableTrait;

    private $priceFrom;
    private $priceTo;

    /**
     * PriceRange constructor.
     * @param $priceFrom
     * @param $priceTo
     */
    public function __construct($priceFrom, $priceTo)
    {
        $this->priceFrom = $priceFrom;
        $this->priceTo = $priceTo;
    }

    /**
     * @return mixed
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * @return mixed
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }
}