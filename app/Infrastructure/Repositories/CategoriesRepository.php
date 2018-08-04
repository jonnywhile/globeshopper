<?php namespace App\Infrastructure\Repositories;

use App\Domain\Requests\Category;
use App\Infrastructure\Models\Category as CategoryModel;

class CategoriesRepository
{
    public function all() {
        $categories = CategoryModel::all();

        $result = collect();

        foreach ($categories as $category) {
            $result->push(Category::makeFromModel($category));
        }

        return $result;
    }

    public function get($id) {
        $category = (new CategoryModel)->find($id);

        return Category::makeFromModel($category);
    }
}