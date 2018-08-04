<?php namespace App\Infrastructure\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'from_user_id',
        'to_globshopper_id',
        'name',
        'description',
        'category_id',
        'amount',
        'price_from',
        'price_to',
        'picture',
        'status',
        'is_cancelled',
        'is_closed'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function globshopper() {
        return $this->belongsTo(Globshopper::class, 'to_globshopper_id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function offer() {
        return $this->hasOne(Offer::class);
    }

    public function rating() {
        return $this->hasOne(Rating::class);
    }

    public function charge() {
        return $this->hasOne(Charge::class);
    }

    public function complaint() {
        return $this->hasOne(Complaint::class);
    }

}