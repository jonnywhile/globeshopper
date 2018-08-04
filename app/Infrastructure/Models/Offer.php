<?php namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'delivery_date'
    ];

    protected $fillable = [
        'request_id',
        'name',
        'description',
        'amount',
        'price',
        'delivery_fee',
        'delivery_date',
        'delivery_type',
        'picture'
    ];

    public function request() {
        return $this->belongsTo(Request::class, 'request_id');
    }
}