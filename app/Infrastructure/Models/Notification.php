<?php namespace App\Infrastructure\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'user_id',
        'text'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeNew($query) {
        return $query->where('is_seen', false);
    }
}