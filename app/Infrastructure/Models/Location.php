<?php namespace App\Infrastructure\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'location'
    ];

    protected $appends = ['formatted_location'];

    public function getFormattedLocationAttribute() {
        try {
            $location = json_decode($this->location);
            return head($location);
        } catch(\Exception $e) {
            return null;
        }
    }
}