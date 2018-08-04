<?php namespace App\Domain\Globshoppers;


use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;

class Location
{
    use PropertiesTrait, JsonableTrait;

    private $json;
    private $data;

    public function __construct($json)
    {
        $this->json = $json;
        try {
            $location = json_decode($json);
            $this->data = head($location);
        } catch(\Exception $e) {}
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    public static function makeFromModel(\App\Infrastructure\Models\Location $location) {
        return new self($location->location);
    }
}