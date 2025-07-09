<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comms_id', 'user_id', 'comment', 'type'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 
    ];

    public function comms()
    {
        return $this->belongsTo(Comms::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'first_name', 'last_name', 'avatar');
    }
}
