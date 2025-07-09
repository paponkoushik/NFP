<?php

namespace App\Models;

use App\Models\Traits\CreatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalRequestNote extends Model
{
    use HasFactory, CreatedBy;

    /**
     * Get the note of the legal request.
     *
     */
    public function legalRequest()
    {
        return $this->belongsTo(LegalRequest::class);
    }

    /**
     * Get the created by of the legal note.
     *
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'first_name', 'last_name', 'email', 'phone');
    }
}
