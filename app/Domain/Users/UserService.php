<?php namespace App\Domain\Users;

use App\Domain\Globshoppers\Globshopper;
use App\Domain\Globshoppers\Location;
use App\Infrastructure\Repositories\GlobshopperRepository;
use App\User;
use Intervention\Image\Facades\Image;

/**
 * Class UserService
 * @package App
 */
class UserService
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
        $this->user->load('globshopper.location');
    }

    /**
     * Update Profile
     * @param $data
     */
    public function updateProfile($data) {

        $globshopperRepo = new GlobshopperRepository();

        $this->user->update([
            'first_name' => array_get($data, 'first_name', ''),
            'last_name' => array_get($data, 'first_name', '')
        ]);

        // If User is upgraded to Globshopper
        if (! empty(array_get($data, 'is_globshopper', false))) {

            $globshopper = null;

            // If user is already globshopper
            if ($this->user->globshopper) {
                $globshopper = $this->user->globshopper;
                // Delete old location
                if ($globshopper->location) {
                    $globshopper->location->delete();
                }
            } else {

                $globshopper = new Globshopper(
                    null,
                    $this->user,
                    array_get($data, 'stripe_public_key', ''),
                    array_get($data, 'stripe_secret_key', '')
                );

                $globshopper = $globshopperRepo->store($globshopper);
            }

            // Create new location
            $location = Location::create(['location' => array_get($data, 'location')]);
            // Update globshopper
            $globshopper->update([
                'location_id' => $location->id,
                'stripe_key' => array_get($data, 'stripe_key', '')
            ]);

            $this->user->update([
                'type' => 'globshopper'
            ]);

        } else {
            // Delete globshopper if exists
            if ($this->user->globshopper) {
                $this->user->globshopper->delete();
            }

            $this->user->update([
                'type' => 'buyer'
            ]);
        }

        return $this->user;
    }

    public function updateAvatar($avatar) {

        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(300, 300)->save(public_path('/avatars/' . $filename));

        $this->user->update(['avatar' => $filename]);
    }

    public function search($data) {

        $users = User::with('globshopper.location')
            ->where(function($query) use ($data) {
                foreach ($data as $key => $value) {
                    if (! empty($value)) {
                        $query->whereRaw("lower({$key}) like '%" . strtolower($value) . "%'");
                    }
                }
            })
            ->get();

        return $users;
    }
}