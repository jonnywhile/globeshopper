<?php namespace App\Domain\Globshoppers;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;

class Portfolio
{
    use PropertiesTrait, JsonableTrait;

    private $html;

    public function __construct($html)
    {
        $this->html = $html;
    }

    /**
     * @return mixed
     */
    public function getHtml()
    {
        return $this->html;
    }

    public static function makeFromModel(\App\Infrastructure\Models\Portfolio $portfolio) {
        return new self($portfolio->html);
    }
}