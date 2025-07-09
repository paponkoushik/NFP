<?php

namespace App\Models;

use App\Actions\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SavedAdvertisement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'advertisement_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Get the user of the saved-advertisement.
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'full_name', 'email');
    }

    /**
     * Get the advertisement of the saved-advertisement.
     *
     */
    public function advertisement()
    {
        return $this->belongsTo(Listing::class)->select('id', 'title', 'description', 'price');
    }

    /**
     * Query Filter.
     *
     * @param  QueryFilter $filters
     * @return Collection
     */
    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
