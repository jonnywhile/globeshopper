<?php namespace App\Domain\Base;

trait PropertiesTrait {

    public function __get($property) {
        return $this->{$property};
    }
}