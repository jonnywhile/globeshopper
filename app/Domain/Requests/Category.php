<?php namespace App\Domain\Requests;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use App\Infrastructure\Models\Category as CategoryModel;

class Category
{
    use PropertiesTrait, JsonableTrait;

    private $id;
    private $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    public static function makeFromModel(CategoryModel $category) {

        return new self($category->id, $category->name);
    }


}