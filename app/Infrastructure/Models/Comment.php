<?php namespace App\Infrastructure\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'complaint_comments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'complaint_id',
        'comment',
        'created_by'
    ];

    protected $appends = ['formatted_created_at'];

    public function complaint() {
        return $this->belongsTo(Complaint::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFormattedCreatedAtAttribute() {
        return $this->created_at->format('m/d/Y');
    }

}