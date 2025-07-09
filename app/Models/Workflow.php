<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public static function getBadgeClass(string $status, string|null $stage = null): string
    {
        $colors = [
            'new' => 'facebook',
            'in-progress' => 'warning',
            'done' => 'success',
            'invalid' => 'danger',
            'on-hold' => 'secondary'
        ];

        return $colors[removeSpace(strtolower($status), '-')] ?? $colors[$stage] ?? 'secondary';
    }
}
