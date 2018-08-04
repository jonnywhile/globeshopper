<?php namespace App\Domain\Users;

use App\Domain\Base\JsonableTrait;
use App\Domain\Base\PropertiesTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class User
{
    use PropertiesTrait, JsonableTrait;

    private $id;

    private $firstName;
    private $lastName;
    private $type;
    private $email;
    // Avatar instance
    private $avatar;

    /**
     * User constructor.
     * @param $id
     * @param $name
     * @param $type
     * @param $avatar
     */
    public function __construct(
        $id,
        $firstName,
        $lastName,
        $email,
        $type,
        $avatar
    )
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->type = $type;
        $this->avatar = $avatar;
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    public function changeAvatar($avatar)
    {
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->resize(300, 300)->save(public_path('/avatars/' . $filename));

        $this->avatar = new Avatar($filename);
    }

    public function updateProfile($data)
    {
        foreach ($data as $key => $value) {
            if ($value !== null) {
                $index = camel_case($key);
                $this->{$index} = $value;
            }
        }
    }

    public function canMakeComplaint($request, $offer) {
        $canMakeComplaint = false;

        if ($this->type == 'buyer' && $offer && $request->status === 'OFFER_ACCEPTED') {
            $deadline = $offer->deliveryDate->copy()->addDays(30);

            if (Carbon::now()->gt($offer->deliveryDate) && Carbon::now()->lt($deadline)) {
                $canMakeComplaint = true;
            }
        }

        return $canMakeComplaint;
    }

    public static function makeFromModel(\App\User $user) {
        $avatar = new Avatar($user->avatar);

        return new self(
            $user->id,
            $user->first_name,
            $user->last_name,
            $user->email,
            $user->type,
            $avatar);
    }


}