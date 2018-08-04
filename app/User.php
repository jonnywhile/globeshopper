<?php

namespace App;

use App\Infrastructure\Models\Globshopper;
use App\Domain\Requests\Request;
use App\Infrastructure\Models\Notification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'avatar',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['name'];

    public function globshopper()
    {
        return $this->hasOne(Globshopper::class, 'user_id');
    }

    public function is($type)
    {
        return $this->type === $type;
    }

    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function requests() {
        return $this->hasMany(Request::class, 'from_user_id');
    }

    public function newNotifications() {
        return $this->hasMany(Notification::class, 'user_id')->new();
    }
}
