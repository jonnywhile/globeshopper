<?php namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use SoftDeletes;

    protected $table = 'globshopper_portfolios';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'globshopper_id',
        'html'
    ];
}