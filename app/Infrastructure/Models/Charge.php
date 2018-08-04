<?php namespace App\Infrastructure\Models;

use App\Domain\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'charge_id',
        'customer_id',
        'amount',
        'request_id'
    ];

    public function request() {
        return $this->belongsTo(Request::class, 'request_id');
    }
}