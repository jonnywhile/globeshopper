<?php namespace App\Infrastructure\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complaint extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'request_id',
        'is_resolved'
    ];

    public function request() {
        return $this->belongsTo(Request::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->orderBy('created_at');
    }
}