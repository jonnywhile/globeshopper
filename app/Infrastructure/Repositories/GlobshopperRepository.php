<?php namespace App\Infrastructure\Repositories;

use App\Domain\Globshoppers\Globshopper;
use App\Infrastructure\Models\Globshopper as GlobshopperModel;
use App\Infrastructure\Models\Location as LocationModel;
use App\Infrastructure\Models\Portfolio as PortfolioModel;
use App\User;

/**
 * Created by PhpStorm.
 * User: Bojana
 * Date: 10/4/17
 * Time: 1:30 PM
 */
class GlobshopperRepository
{
    public function all() {
        $globshoppers = (new GlobshopperModel())->with([
            'user', 'location'
        ])->get();

        $result = collect();

        foreach ($globshoppers as $globshopper) {
            $result->push(Globshopper::makeFromModel($globshopper));
        }

        return $result;
    }

    public function getByUserId($userId) {
        $globshopper = (new GlobshopperModel())
            ->where('user_id', $userId)
            ->first();

        return ($globshopper) ? Globshopper::makeFromModel($globshopper) : null;
    }

    public function get($id) {
        $globshopper = (new GlobshopperModel())->find($id);

        return Globshopper::makeFromModel($globshopper);
    }

    public function store(Globshopper $globshopper) {
        // Get globshopper if exists
        $existing = (new GlobshopperModel())->where('user_id', $globshopper->user->id)->first();
        // Delete location if exists
        if ($existing !== null && $existing->location_id !== null) {
            (new LocationModel())->destroy($existing->location_id);
        }
        // Create new location
        $location = (new LocationModel())->create([
            'location' => $globshopper->location->json
        ]);

        return (new GlobshopperModel())->updateOrCreate(
            ['user_id' => $globshopper->user->id],
            [
                'stripe_public_key' => $globshopper->stripePublicKey,
                'stripe_secret_key' => $globshopper->stripeSecretKey,
                'location_id' => $location->id
            ]
        );
    }

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

        $result = collect();

        foreach ($globshoppers as $user) {
            $result->push(Globshopper::makeFromModel($user->globshopper));
        }

        return $result;
    }

    public function remove(Globshopper $globshopper) {
        $item = (new GlobshopperModel())->find($globshopper->id);

        $item->delete();
    }

    public function savePortfolio(Globshopper $globshopper) {
        return (new PortfolioModel())->updateOrCreate(
            ['globshopper_id' => $globshopper->id],
            [
                'html' => $globshopper->portfolio->html
            ]
        );
    }

}