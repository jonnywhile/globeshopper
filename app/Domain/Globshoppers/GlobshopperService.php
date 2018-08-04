<?php namespace App\Domain\Globshoppers;

use App\User;

class GlobshopperService
{
    public function search($data) {

        $globshoppers = User::with('globshopper.location')
            ->where(function($query) use ($data) {
                foreach ($data as $key => $value) {
                    if (! empty($value)) {
                        $query->whereRaw("lower({$key}) like '%" . strtolower($value) . "%'");
                    }
                }
            })
            ->where('type', 'globshopper')
            ->get();

        return $globshoppers;
    }
}