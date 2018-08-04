<?php namespace App\Infrastructure\Repositories;

use App\Domain\Globshoppers\Globshopper;
use App\Domain\Users\Avatar;
use App\User as UserModel;
use App\Domain\Users\User as User;

class UsersRepository
{
    public function getAll($data = null){
        $users = (new UserModel());

        if (! empty($data)) {
            $users->where(
                function ($query) use ($data) {
                    foreach ($data as $key => $value) {
                        if (!empty($value)) {
                            $query->whereRaw("lower({$key}) like '%".strtolower($value)."%'");
                        }
                    }
                }
            );
        }

        $users = $users->get();

        $result = collect();

        foreach ($users as $item) {
            $result->push(User::makeFromModel($item));
        }

        return $result;
    }

    public function get($id) {
        $user = (new UserModel())->find($id);

        return User::makeFromModel($user);
    }

    public function store(User $user) {
        return (new UserModel())->updateOrCreate(
            ['id' => $user->id],
            [
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'type' => $user->type,
                'avatar' => $user->avatar->name
            ]
        );
    }
}