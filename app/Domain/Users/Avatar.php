<?php namespace App\Domain\Users;


use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;

class Avatar
{
    use PropertiesTrait, JsonableTrait;

    private $name;
    private $url;

    public function __construct($name)
    {
        $this->name = $name;
        $this->url = 'avatars/' . $this->name;
    }

    public function getUrl() {
        return 'avatars/' . $this->name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}