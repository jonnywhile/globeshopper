<?php namespace App\Infrastructure\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Globshopper extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'stripe_public_key',
        'stripe_secret_key',
        'location_id'
    ];

    protected $appends = ['name'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function portfolio() {
        return $this->hasOne(Portfolio::class);
    }

    public function requests() {
        return $this->hasMany(Request::class, 'to_globshopper_id');
    }

    public function getNameAttribute() {
        return $this->user->first_name . ' ' . $this->user->last_name;
    }
}